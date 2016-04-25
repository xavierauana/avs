<style></style>
<template>
    <modal :show="show">
        <h3 slot="header">Login Info</h3>

        <form slot="body" class="form" id="loginForm" @submit.prevent="login">
            <div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>

            </div>
            <div>
                <button class="btn modal-default-button"
                        @click.prevent="show = false">
                    OK
                </button>
                <button class="btn modal-default-button">Login</button>
            </div>
        </form>
        <div slot="footer"></div>
    </modal>
</template>

<script>
    import Modal from './modal.vue'
    export default{
        http: {
            headers: {
                "X-CSRF-TOKEN": document.getElementById('csrf-token').getAttribute('content')
            }
        },
        props: {
            show: false,
            auth: {
                type: Boolean,
                default: false
            },
            user: {
                type: Object,
                default: function () {
                    return {}
                }
            }
        },
        components: {
            Modal
        },
        methods: {
            login: function (e) {
                var form = document.querySelector('form#loginForm'),
                        data = new FormData(e.target);
                this.apiAuth(data).then(
                        function (response) {
                            if (!response.data.user) {
                                swal("Oops...", response.data.message, "error");
                            } else {
                                this.$dispatch("userChanged",response.data.user);
                                this.$dispatch("authChanged", true);
                                this.$set('show', false);
                            }
                        },
                        function (response) {
                            this.$set('show', false);
                            var message = "";
                            for (var key in response.data) {
                                message = message + response.data[key] + " "
                            }
                            swal("Oops... Connection Errors", message, "error");
                        })
            }
        }
    }
</script>