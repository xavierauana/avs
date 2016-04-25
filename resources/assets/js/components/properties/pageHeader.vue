<style src="./../style/frontEndHeader.css"></style>
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
                        <li>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="/auth/logout">{{user.name}} </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
    </header>
</template>

<script>

    export default {
        props:{
            user:Object,
            default:function(){
                return{}
            }
        },
        ready:function(){
            console.log('from front end header')
        }
    }
</script>