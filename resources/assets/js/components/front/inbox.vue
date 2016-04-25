<style src="./style/detail.css"></style>
<template>
    <front-page-template :user.sync="user" :auth.sync="auth">
        <div slot="content" class="container" id="house_detail">
            <h1 class="page-title">
                My Inbox
            </h1>
            <message-room
             :rooms="getMessageRooms | removeNoMassage"
            :user="user"></message-room>

            <br>
            <modal :show.sync="modalShow">
                <h2 slot="header">
                    Messages
                </h2>
                <div slot="body">
                    <ul class="list-unstyled">
                        <li v-for="message in messages" :class="{'right':amISentThis(message),'left':!amISentThis(message)}">
                            {{message.message}}
                        </li>
                    </ul>
                </div>
                <div slot="footer">
                    <textarea class="form-control" name="message" cols="30" rows="5" v-model="message"></textarea>
                    <br>
                    <button class="btn btn-info">Reply</button>
                    <button class="btn btn-default" @click.previent="closeMessageModal">Close</button>
                </div>
            </modal>
        </div>
    </front-page-template>
</template>


<script>
    import FrontPageTemplate from './../frontPageTemplate.vue'
    import MessageRoom from './messageRoom.vue'
    import Modal from './../modal.vue'

    export default{
        route: {
            data: function () {
                this.authorization();
                this.apiGetMessages().then(function (response) {
                    if (response.data.code == 'okay') this.$set('messageRooms', response.data.data)
                })
            }
        },
        data: function () {
            return {
                messageRooms: [],
                user: {},
                auth: false,
                modalShow:false,
                messages:[],
                message:""
            }
        },
        computed:{
            getMessageRooms: function(){
                return this.messageRooms.length==0?[]:this.messageRooms
            }
        },
        components: {
            FrontPageTemplate,
            Modal,
            MessageRoom
        },
        events:{
            topLevelUserUpdated:function(user){
                this.$set('user', user);
            },
            topLevelAuthUpdated:function(auth){
                this.$set('auth', auth);
            },
            showMessageRoom:function(room){
                this.showMassages(room);
            }
        },
        filters:{
          removeNoMassage: function(messageRooms){
                  return messageRooms.filter(function(room){
                      return room.messages.length>0;
                  })
          }
        },
        methods: {
            showOtherParticipantsName: function (room) {
                var names = room.users.reduce(function (previousValue, participant) {
                    console.log('Previous Value is ', previousValue);
                    return participant.name != this.user.name ? previousValue + participant.name + ', ' : previousValue;
                }.bind(this), '');
                console.log(names.slice(0, -2));
                return names.slice(0, -2);
            },
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
            showMassages: function(room){
                this.modalShow = true;
                this.messages = room.messages;
            },
            amISentThis: function(message){
                return message.sender_id == this.user.id
            },
            closeMessageModal: function(){
                this.modalShow = false;
                this.message = "";
            }
        }
    }
</script>