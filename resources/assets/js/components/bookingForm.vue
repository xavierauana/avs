<style></style>
<template>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="booking">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class='input-group date'>
                            <input type='text' name="checkInDate" id="checkInDate"
                                   class="form-control dateTime" placeholder="Check In Date"/>
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class='input-group date'>
                            <input type='text' name="checkOutDate" id="checkOutDate"
                                   class="form-control dateTime" placeholder="Check Out Date"/>
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div v-show="services.length>0">
                <p>The host also provide additional service as below</p>
                <ul class="list-unstyled">
                    <li v-repeat="service in services">
                        <input class="services" type="checkbox" data-name="@{{service.name}}"
                               data-type="@{{service.type}}" data-price="@{{service.price}}"
                               data-id="@{{service.id}}">
                        <h4>@{{service.name}}</h4>

                        <div v-html="service.summary"></div>
                        <p v-show="service.type == 'daily'">Only HK$ @{{service.price}} per date</p>

                        <p v-show="service.type != 'daily'">Only once off HK$ @{{service.price}}</p>
                    </li>
                </ul>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="payment">
            <p>The overall total amount is HK$ <span id="overallTotalAmount"></span></p>

            <div id="purchaseServices" v-repeat="messages">@{{ $value }}</div>
            <form name="payForm" method="post" v-on="submit:pay"
                  action="https://test.paydollar.com/b2cDemo/eng/payment/payForm.jsp">
                <input type="hidden" name="merchantId" value="{{env("MERCHAINT_ID")}}">
                <input type="hidden" name="amount" value="" >
                <input type="hidden" name="orderRef" value="">
                <input type="hidden" name="currCode" value="{{env("BASE_CURRENCY_CODE")}}" >
                <input type="hidden" name="payType" value="N" >
                <input type="hidden" name="successUrl" value="">
                <input type="hidden" name="failUrl" value="">
                <input type="hidden" name="errorUrl" value="">
                <input type="hidden" name="lang" value="E">
                <input type="hidden" name="secureHash" value="44f3760c201d3688440f62497736bfa2aadd1bc0">
                <button type="submit" class="btn btn-primary">Pay Now</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default{}
</script>