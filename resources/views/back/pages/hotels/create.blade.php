@extends("back.layouts.default")

@section("content")
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Create A New Hotel</h4>
        </div>
        <div class="panel-body">
            <form action="{{route('manager.hotels.store')}}" method="post" role="form">
                <input type='hidden' name='_token' value='{{csrf_token()}}'>

                <fieldset>
                    <legend>Language Independent Info</legend>

                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">Phone</label>

                        <div class="col-sm-10">
                            <input name="phone" type="text" class="form-control" id="phone" placeholder="Phone">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fax" class="col-sm-2 control-label">Fax: </label>

                        <div class="col-sm-10">
                            <input name="fax" type="text" class="form-control" id="fax" placeholder="Fax">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="country" class="col-sm-2 control-label">Country: </label>

                        <div class="col-sm-10">
                            <select name="country" id="country" class="form-control">
                                <option value="hk" selected>Hong Kong</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="timezone" class="col-sm-2 control-label">Local Timezone: </label>
                        <div class="col-sm-10">
                            <select name="timezone" id="timezone" class="form-control">

                                <option value="">-- select --</option>
                                <option value="-12">[UTC - 12] Baker Island Time</option>
                                <option value="-11">[UTC - 11] Niue Time, Samoa Standard Time</option>
                                <option value="-10">[UTC - 10] Hawaii-Aleutian Standard Time, Cook Island Time</option>
                                <option value="-9.5">[UTC - 9:30] Marquesas Islands Time</option>
                                <option value="-9">[UTC - 9] Alaska Standard Time, Gambier Island Time</option>
                                <option value="-8">[UTC - 8] Pacific Standard Time</option>
                                <option value="-7">[UTC - 7] Mountain Standard Time</option>
                                <option value="-6">[UTC - 6] Central Standard Time</option>
                                <option value="-5">[UTC - 5] Eastern Standard Time</option>
                                <option value="-4.5">[UTC - 4:30] Venezuelan Standard Time</option>
                                <option value="-4">[UTC - 4] Atlantic Standard Time</option>
                                <option value="-3.5">[UTC - 3:30] Newfoundland Standard Time</option>
                                <option value="-3">[UTC - 3] Amazon Standard Time, Central Greenland Time</option>
                                <option value="-2">[UTC - 2] Fernando de Noronha, S. Georgia &amp; the S. Sandwich Islands
                                    (Time)
                                </option>
                                <option value="-1">[UTC - 1] Azores Standard Time, Cape Verde Time, Eastern Greenland Time
                                </option>
                                <option value="0" selected="selected">[UTC] Western European Time, Greenwich Mean Time</option>
                                <option value="1">[UTC + 1] Central European Time, West African Time</option>
                                <option value="2">[UTC + 2] Eastern European Time, Central African Time</option>
                                <option value="3">[UTC + 3] Moscow Standard Time, Eastern African Time</option>
                                <option value="3.5">[UTC + 3:30] Iran Standard Time</option>
                                <option value="4">[UTC + 4] Gulf Standard Time, Samara Standard Time</option>
                                <option value="4.5">[UTC + 4:30] Afghanistan Time</option>
                                <option value="5">[UTC + 5] Pakistan Standard Time, Yekaterinburg Standard Time</option>
                                <option value="5.5">[UTC + 5:30] Indian Standard Time, Sri Lanka Time</option>
                                <option value="5.75">[UTC + 5:45] Nepal Time</option>
                                <option value="6">[UTC + 6] Bangladesh Time, Bhutan Time, Novosibirsk Standard Time</option>
                                <option value="6.5">[UTC + 6:30] Cocos Islands Time, Myanmar Time</option>
                                <option value="7">[UTC + 7] Indochina Time, Krasnoyarsk Standard Time</option>
                                <option value="8" selected>[UTC + 8] Hong Kong, Chinese, Australian Western, Irkutsk (Standard Time)</option>
                                <option value="8.75">[UTC + 8:45] Southeastern Western Australia Standard Time</option>
                                <option value="9">[UTC + 9] Japan Standard Time, Korea Standard Time, Chita Standard Time
                                </option>
                                <option value="9.30">[UTC + 9:30] Australian Central Standard Time</option>
                                <option value="10">[UTC + 10] Australian Eastern Standard Time, Vladivostok Standard Time
                                </option>
                                <option value="10.5">[UTC + 10:30] Lord Howe Standard Time</option>
                                <option value="11">[UTC + 11] Solomon Island Time, Magadan Standard Time</option>
                                <option value="11.5">[UTC + 11:30] Norfolk Island Time</option>
                                <option value="12">[UTC + 12] New Zealand Time, Fiji Time, Kamchatka Standard Time</option>
                                <option value="12.75">[UTC + 12:45] Chatham Islands Time</option>
                                <option value="13">[UTC + 13] Tonga Time, Phoenix Islands Time</option>
                                <option value="14">[UTC + 14] Line Island Time</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="active" class="col-sm-2 control-label">Active: </label>
                        <div class="col-sm-10">
                            <select name="active" id="active" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">Not Active</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Language Specified Info</legend>

                    <!-- TAB NAVIGATION -->
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($languages = avaluestay\Language::whereActive(1)->get() as $language)
                            <li @if(auth()->user()->defaultLanguage == $language)class="active"@endif><a href="#{{$language->name}}" role="tab" data-toggle="tab">{{$language->label}}</a></li>
                        @endforeach
                    </ul>
                    <!-- TAB CONTENT -->
                    <div class="tab-content">
                        @foreach($languages as $language)
                            <div class="@if(auth()->user()->defaultLanguage == $language) active @endif tab-pane fade in" id="{{$language->name}}">
                                <h2>{{$language->label}}</h2>

                                @include('back.pages.hotels.partials.form', compact('language'))
                            </div>
                        @endforeach
                    </div>




                </fieldset>



                <button type="submit" class="btn btn-success">Create</button>
            </form>
        </div>
    </div>
@endsection