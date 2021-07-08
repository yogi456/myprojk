@extends('layouts.registers')

@section('content')


<div class="container step-3">
    <div class="row">
        <div class="col-md-9 mx-auto">

            <div class="row registration-form-wrap">
                <div class="col-sm-6 mx-auto">
                    <h2 class="text-center">Your Company</h2>
                    <form class="registration-form">
                        <div class="form-group" id="reg-indu-div">
                            <select required id="Industry" class="form-control">
                                <option>Industry</option>
                                <?php session_start(); ?>
                                <?php foreach ($industry_dropdown as $indus) { ?>
                                    <option  value="<?php echo $indus->id; ?>" <?php
                                    if (isset($_SESSION['Industry']) && $_SESSION['Industry'] == $indus->id) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $indus->industry; ?></option>
<?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select required id="Employees" class="form-control">
                                <option selected>Employees</option>

                                <?php foreach ($employee_numbers as $empNum) { ?>

                                    <option  value="<?php echo $empNum->id; ?>" <?php
                                             if (isset($_SESSION['Employees']) && $_SESSION['Employees'] == $empNum->id) {
                                                 echo "selected";
                                             }
                                             ?>><?php echo $empNum->no_of_emp; ?></option>
<?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select required id="Country" class="form-control">
                                <option selected>Country</option>

                                        <?php foreach ($country as $coun) { ?>
                                    <option value="<?php echo $coun->id; ?>" <?php
                                        if (isset($_SESSION['Country']) && $_SESSION['Country'] == $coun->id) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $coun->sortname . '-' . $coun->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select required id="timeZone" class="form-control">
                                <option selected>UTC</option>
                                <option selected>GMT</option>
                                <option selected>IST</option>
                            </select>
                        </div>
                        <div class="form-check">
                            <span>Audience:</span>
                            <label class="form-check-label">                                    
                                <input required name="audience" value="1" <?php
                                       if (isset($_SESSION['audience']) && $_SESSION['audience'] == '1') {
                                           echo "checked";
                                       }
                                       ?> type="checkbox" class="form-check-input">
                                <span>B2B</span>
                            </label>
                            <label required class="form-check-label"> 
                                <input name="audience" value="2" <?php
                                       if (isset($_SESSION['audience']) && $_SESSION['audience'] == '2') {
                                           echo "checked";
                                       }
                                       ?> type="checkbox" class="form-check-input">
                                <span>B2C</span>
                            </label>
                            <label required class="form-check-label"> 
                                <input name="audience" value="3" <?php
                                       if (isset($_SESSION['audience']) && $_SESSION['audience'] == '3') {
                                           echo "checked";
                                       }
                                       ?> type="checkbox" class="form-check-input">
                                <span>Internal</span>
                            </label>
                        </div>

                    </form>
                </div>
            </div>
            <div class="row registration-navigation">
                <div class="col">
                    <!--<a class="btn btn-default float-left btn-prev" href="{{ url('/step2') }}">Previous</a>-->
                    <input type="button" class="btn btn-success float-right btn-next" id="sendStep3" onclick="sendStep2()" value="Next">
                    <a class="btn btn-default float-right btn-skip" href="">Skip</a>
                </div>
            </div>
        </div>
    </div>


</div>


<script>
    function sendStep2() {

        var Industry = $("#Industry").val();
        var Employees = $("#Employees").val();
        var Country = $("#Country").val();
        var audience = $("input[name='audience']:checked").val();
        var _token = '<?php echo csrf_token() ?>';

        if (Industry != '' && Employees != '' && Country != '' && audience != undefined) {
            $.ajax({
                type: 'POST',
                url: 'http://dev.local.com/freechat/step2save',
                data: {_token: _token, Industry: Industry, Employees: Employees, Country: Country, audience: audience},
                success: function (data) {

                    if (data == 'success') {
                        window.location.href = "http://dev.local.com/freechat/step3";
                    } else {
                        alert(data);
                    }
                }
            });
        } else {
            alert("Please Fill All Feilds");
        }
    }

    $(document).ready(function () {
//        setTimeout(function () {
//            $('#reg-indu-div select').selectpicker();
//        }, 500);
    });

</script>
@endsection