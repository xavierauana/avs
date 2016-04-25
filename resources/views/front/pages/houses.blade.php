    @extends("front.layouts.default")

@section('content')
    <front-end-header></front-end-header>
    <components :is="currentView"></components>
    <front-end-footer></front-end-footer>
@endsection

@section('scripts')
    @parent

    <script>
        var checkInInput, checkOutInput, accommodates;
        checkInInput = $('#checkInDate');
        checkOutInput = $('#checkOutDate');
        accommodates = $('#accommodates');
        console.log(accommodates);

        checkInInput.datetimepicker({
            format: 'DD MMMM YYYY',
            useCurrent: false, //Important! See issue #1075
            minDate: moment()
        });
        checkOutInput.datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'DD MMMM YYYY'
        });
        checkInInput.on("dp.change", function (e) {
            checkOutInput.data("DateTimePicker").minDate(e.date);
        });
        checkOutInput.on("dp.change", function (e) {
            checkInInput.data("DateTimePicker").maxDate(e.date);
        });

        if(avaluestay.checkInDate){
            checkInInput.val(avaluestay.checkInDate);
        }else{
            console.log("no check in date")
        }
        if(avaluestay.checkOutDate){
            checkOutInput.val(avaluestay.checkOutDate);
        }else{
            console.log("no check out date")
        }
        if(avaluestay.accommodates){

            accommodates.findOne('option').filter(function() {
                //may want to use $.trim in here
                console.log($(this).attr('value'));
                return $(this).attr('value') == avaluestay.accommodates;
            }).prop('selected', true);
        }else{
            console.log("no accommodates")
        }
    </script>
@endsection