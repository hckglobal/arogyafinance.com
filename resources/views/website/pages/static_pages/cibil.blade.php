@extends('app')

@section('title')
Cibil Test Page
@endsection


@section('styles')
<!-- boootsrap -->
<link rel="stylesheet" href="/assets/admin/bootstrap/css/bootstrap.min.css">
<style type="text/css">
    input,select{
        margin: 5px 0;
    }
    label{
        margin-right: 10px;
    }
</style>
@endsection

@section('content')
@section('content')
<div class="container">
    <div class="row">
        <!-- Panel Wizard Form Container -->
    <div class="panel" id="card-wizard" style="padding-top: 150px;">
<form action="http://122.169.102.98:8090/cibil" method="GET" style="margin:40px 0;">
<label>Full Name :</label><input type="text" name="name" placeholder="Full Name"> <br>
<label>Date Of Birth:</label> <input type="text" name="dob" placeholder="date of Birth (DDMYMY)"> <br>
<label>Gender</label>
<select name="gender">
    <option value="2">Male</option>
    <option value="1">Female</option>
</select><br>
<label>Type of ID Proof</label>
<select name="id_proof_type">
    <option value="01">PAN Card</option>
    <option value="02">Voter Id</option>
     <option value="02">Ration Card</option>
     <option value="02">Passport</option>
     <option value="02">Driver's License</option>
     <option value="02">Adhar Card</option>
</select><br>
<label>Id Proof Number:</label> <input type="text" name="id_proof_no" placeholder="ID Proof Number"> <br>
<label>Mobile Number:</label> <input type="text" name="mobile_no" placeholder="ID Proof Number"> <br>
<label>Address Category:</label>
<select name="address_category">
    <option value="01">Permanent Address</option>
    <option value="02">Office Address</option>
     <option value="03">Residence Address</option>
     <option value="04">Uncategoriezed</option>
</select><br> 
<label>Address Type:</label>
<select name="address_type">
    <option value="01">Owned</option>
    <option value="02">Rented</option>
</select><br>
<label>Address:</label> 
<textarea name="address" placeholder="address"></textarea> <br>
<label>State</label>
<select name="state">
<option value="01">Jammu and Kashmir</option>
<option value="02">Himachal Pradesh</option>
<option value="03">Punjab</option>
<option value="04">Chandigarh</option>
<option value="05">Uttaranchal</option>
<option value="06">Haryana</option>
<option value="07">Delhi</option>
<option value="08">Rajasthan</option>
<option value="09">Uttar Pradesh</option>
<option value="10">Bihar</option>
<option value="11">Sikkim</option>
<option value="12">Arunachal Pradesh</option>
<option value="13">Nagaland</option>
<option value="14">Manipur</option>
<option value="15">Mizoram</option>
<option value="16">Tripura</option>
<option value="17">Meghalaya</option>
<option value="18">Assam</option>
<option value="19">West Bengal</option>
<option value="20">Jharkhand</option>
<option value="21">Orissa</option>
<option value="22">Chhattisgarh</option>
<option value="23">Madhya Pradesh</option>
<option value="24">Gujarat</option>
<option value="25">Daman and Diu</option>
<option value="26">Dadra and Nagar Haveli</option>
<option value="27">Maharashtra</option>
<option value="28">Andhra Pradesh</option>
<option value="29">Karnataka</option>
<option value="30">Goa</option>
<option value="31">Lakshadweep</option>
<option value="32">Kerala</option>
<option value="33">Tamil Nadu</option>
<option value="34">Pondicherry</option>
<option value="35">Andaman and Nicobar Islands</option>
<option value="36">Telangana</option>
</select>
<br>
<label>Pincode: </label><input type="text" name="pincode" placeholder="Pincode"> <br>

<input type="submit" value="submit">
 </form>
 </div>
 </div>
 </div>

@endsection