<style src="./style/headerNavBar.css"></style>
<template>
    <header>
        <section>
            <div class="container">
                <nav class="navbar" id="first-navbar">
                    <ul class="nav navbar-nav">
                        <li><a href="" title=""><i class="fa fa-facebook"></i></a></li>
                        <li><a href="" title=""><i class="fa fa-twitter"></i></a></li>
                        <li><a href="" title=""><i class="fa fa-google"></i></a></li>
                        <li><a href="" title=""><i class="fa fa-youtube"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href=""><i class="fa fa-phone"></i> (852) 1234 5678</a></li>
                        <li><a href=""><i class="fa fa-envelope-o"></i> testing@testing.com</a></li>
                        <li v-show="!auth" v-cloak><a href="" title="" data-toggle="modal" data-target="#signUpForm"
                                                      @click="signUpModal = true">Sign Up</a></li>
                        <li v-show="!auth" v-cloak>
                            <a class="dropdown-toggle" data-toggle="dropdown" @click="singInModalShow = true"
                               :show="noUserSignIn">Sign In </a>
                        </li>
                        <li v-show="auth" v-cloak><a href="/properties/new" title="">List your property</a></li>
                        <li v-show="auth" class="dropdown" v-cloak>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">{{user.name}} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/myreservation" @click.prevent="" v-link="{name:'myReservation'}">My
                                    Reservation</a></li>
                                <li><a href="/properties">Manage Your Properties</a></li>
                                <li><a href="/inbox" @click.prevent="" v-link="{name: 'myInbox'}">Your Inbox</a></li>
                                <li><a href="/auth/logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <sign-in-modal :show.sync="singInModalShow" :auth="auth" :user="user"></sign-in-modal>
                <modal :show="signUpModal">
                    <h3 slot="header">Sign Up</h3>

                    <div slot="body">
                        <form class="form" id="registerForm">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Your name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password"
                                       required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password_confirmation"
                                       placeholder="Password" required>
                            </div>
                        </form>
                    </div>
                    <div slot="footer">
                        <button class="btn modal-default-button"
                                @click.prevent="signUpModal = false">
                            OK
                        </button>
                        <input type="submit" value="Sing Up!" class="btn modal-default-button"
                               @click.prevent="register">
                    </div>
                </modal>
            </div>
            <slot></slot>
        </section>
    </header>

</template>

<script>
    import Modal from './../../modal.vue'
    import SignInModal from './../../signInModal.vue'
    export default{
        http: {
            headers: {
                "X-CSRF-TOKEN": document.getElementById('csrf-token').getAttribute('content')
            }
        },
        props: {
            user: {
                type: Object,
                required: true,
                default: function () {
                    return {}
                }
            },
            auth: {
                type: Boolean,
                required: true,
                default: false
            }
        },
        data: function () {
            return {
                singInModalShow: false,
                signUpModal: false
            }
        },
        components: {
            Modal,
            SignInModal
        },
        methods: {
            register: function () {
                var data, url;
                data = new FormData(document.querySelector("#registerForm"));
                url = '/auth/register';
                this.$http.post(url, data).then(function (response) {
                    if (response.data.register) {
                        document.querySelector("#registerForm").reset();
                        this.authorization();
                        this.$set('signUpModal', false);
                    }
                })
            }
        }
    }
</script>