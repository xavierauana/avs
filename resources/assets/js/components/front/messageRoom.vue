<style></style>
<template>
    <ul class="list-unstyled">
        <li v-show="rooms.length==0">
            You don't have any messages now!
        </li>
        <li v-for="room in rooms ">
            <p>Message Between {{showOtherParticipantsName(room)}}</p>
            <p>{{showFirstMessageSummary(room)}}</p>
            <button @click.prevent="showMassages(room)" class="btn btn-default">Show All Message</button>
        </li>
    </ul>
</template>

<script>
    export default{
        props:{
            rooms:{
                type:Array,
                required: true,
                default: function(){
                    return []
                }
            },
            user:{
                type:Object,
                required:true
            }
        },
        methods:{
            showFirstMessageSummary: function(room){
                if(room.messages.length>0){
                    if(room.messages[0].message.length > 10){
                        return room.messages[0].message.slice(0,10)+"..."
                    }else{
                        return room.messages[0].message
                    }
                }else{
                    return ""
                }
            },
            showOtherParticipantsName: function (room) {
                var names = room.users.reduce(function (previousValue, participant) {
                    return participant.name != this.user.name ? previousValue + participant.name + ', ' : previousValue;
                }.bind(this), '');
                return names.slice(0, -2);
            },
            showMassages:function(room){
                this.$dispatch('showMessageRoom', room);
            }
        }
    }
</script>