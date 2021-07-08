@extends('layouts.app')

@section('content')

   <!-- Page Content -->
    <div class="page-heading contact-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>User Information</h4>
              
            </div>
          </div>
        </div>
      </div>
    </div>
<div class="send-message">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>May I know your information.</h2>
            </div>
          </div>
          <div class="col-md-8">
            <div class="contact-form">
              <form id="userregisrerform" action="{{url('userRegisterSubmit')}}" method="post">
                <div class="row">
                   <div class="col-lg-12 col-md-12 col-sm-12">
                    <label>Phone</label>
                    <fieldset>
                      <input name="phone" readonly="readonly" value="{{Auth::user()->phone}}" onkeyup="checkdata(this.value)" placeholder="Phone Number" type="text" class="form-control" id="phone"  required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <label>Full Name</label>
                    <fieldset>
                      <input name="name" readonly="readonly"  type="text" value="{{Auth::user()->name}}" class="form-control" id="name" placeholder="Full Name" required="">
                    </fieldset>
                  </div>
                 
                  <div class="col-lg-12 col-md-12 col-sm-12" style="display:none">
                    <label>Gender</label>
                    <fieldset>
                      
                    <!--   <select class="form-control" name="gender" id="gender"> 
                            <option value="MALE">MALE</option>
                            <option value="FEMALE">FEMALE</option>
                      </select> -->
                        <input name="gender"  type="text" value="{{Auth::user()->gender}}" class="form-control" id="gender" placeholder="Full Name" required="">
                    </fieldset>
                  </div>
                 
                  <div class="col-lg-12 col-md-12 col-sm-12"  style="display:none">
                    <label>Date Of Birth</label>
                    <fieldset>
                      <input name="dob"  value="{{Auth::user()->dob}}"  type="text" class="form-control" id="dob" placeholder="YYYY-MM-DD" required="">
                    </fieldset>
                  </div>

                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="filled-button">Next</button>
                    </fieldset>
                  </div>
                </div>
              </form>
              <div id="returnres"> </div>
            </div>
          </div>
          <div class="col-md-4">
            <!-- <ul class="accordion">
              <li>
                  <a>Accordion Title One</a>
                  <div class="content">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti elite.</p>
                  </div>
              </li>
              <li>
                  <a>Second Title Here</a>
                  <div class="content">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti elite.</p>
                  </div>
              </li>
              <li>
                  <a>Accordion Title Three</a>
                  <div class="content">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti elite.</p>
                  </div>
              </li>
              <li>
                  <a>Fourth Accordion Title</a>
                  <div class="content">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti elite.</p>
                  </div>
              </li>
            </ul> -->
          </div>
        </div>
      </div>
    </div>


 
      <script  >



  function checkdata(number) {

            $.ajax({
                type: 'get',
                url: '{{url("checknumber")}}/'+number,
                
                success: function (data) {
                   var obj =JSON.parse(data)
                    if (obj.data == 1) {
                        $("#name").val(obj.user.name)
                        $("#dob").val(obj.user.dob)
 
                        $('#gender option[value='+obj.user.gender+']').attr('selected','selected');
                    } else {
                         $("#name").val('')
                    }
                }
            });
        } 



    </script>

@endsection
