<?php
/**
 * Author: Xavier Au
 * Date: 14/3/16
 * Time: 1:05 PM
 */

namespace App\Services;


use App\Jobs\UserSendMessageToPropertyOwner;
use App\MessageRoom;
use App\Property;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageService
{
    use DispatchesJobs;

    private $request;

    private $commonMessageRoomId = "";

    private $sender;

    /**
     * MessageService constructor.
     * @param $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->sender = $this->request->user();
    }

    public function sendMessage()
    {

        $this->getMessageRoom();

        $this->persistMessage();

        $this->sendEmailNotifications();
    }

    private function getMessageRoom()
    {
        $sender = $this->request->user();
        $receiver = Property::findOrFail($this->request->get('propertyId'))->owner;

        $roomIds = DB::table('message_room_user')->where('user_id', $sender->id)->orWhere('user_id',
            $receiver->id)->lists('message_room_id');

        foreach (array_count_values($roomIds) as $roomId => $count) {
            if ($count > 1) {
                $this->commonMessageRoomId = $roomId;
            }
        }
        if (!$this->commonMessageRoomId) {
            $room = MessageRoom::create([]);
            $this->commonMessageRoomId = $room->id;
            $sender->messageRooms()->attach($room);
            $receiver->messageRooms()->attach($room);
        }
    }

    private function persistMessage()
    {
        $sender = $this->request->user();
        $data = [
            'message'         => $this->request->get('message'),
            'message_room_id' => $this->commonMessageRoomId,
        ];
        $sender->messages()->create($data);
    }

    private function sendEmailNotifications()
    {
        $property = Property::findOrFail($this->request->get('propertyId'));

        $message = $this->request->get('message');

        $job = (new UserSendMessageToPropertyOwner($this->sender,
            $message, $property->owner))->onQueue('emails');

        $this->dispatch($job);
    }


}