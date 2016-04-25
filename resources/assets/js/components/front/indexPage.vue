<template>
    <front-page-template :user="user" :auth="auth">
        <header-carousel
                slot="header-carousel"
                :carousel-items="carouselItems"></header-carousel>
        <div slot="content" class="container">
            <index-page-search-form></index-page-search-form>

            <advertisment1></advertisment1>

            <promotions></promotions>
        </div>
    </front-page-template>
</template>

<script>
    import IndexPageHeader from './../indexPageHeader.vue'
    import IndexPageSearchForm from './../indexPageSearchForm.vue'
    import Advertisment1 from './../indexPageAd1.vue'
    import Promotions from './../promotions.vue'
    import FrontPageTemplate from './../frontPageTemplate.vue'
    import HeaderCarousel from './../headerCarousel.vue'

    export default{
       created: function(){
           console.log('calling from activate');
           this.authorization();
       },
        data: function () {
            return {
                user: {},
                auth: false,
                carouselItems:[
                    {
                        src:"http://lorempixel.com/1440/490/city",
                        title:"this is title 1",
                        description:"this is description 1"
                    },
                    {
                        src:"http://lorempixel.com/1440/490/city",
                        title:"this is title 2",
                        description:"this is description 2"
                    }
                ]
            }
        },
        events:{
          topLevelUserUpdated:function(user){
              this.$set('user', user);
          },
            topLevelAuthUpdated:function(auth){
              this.$set('auth', auth);
          }
        },
        components: {
            IndexPageHeader,
            IndexPageSearchForm,
            Advertisment1,
            Promotions,
            FrontPageTemplate,
            HeaderCarousel
        }
    }
</script>