<div class="form-group">
<!--     <h3> &#8377; Declaration</h3>
 -->    <div class="col-md-12">
        <label class="input-label-space" for="small-hatchback">Do you have an Arogya Card ?</label>
        <button class="btn-primary btn" type="button" onclick='window.location.assign("/login?next=user/apply-for-loan")'>Yes</button> 

        <button class="btn btn-primary btn-red no" type="button">No</button>
    
    </div>
</div>

<div class="form-group">
    <h3><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Nominees Info</h3>
    <div class="col-sm-4">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        <label>Name*</label>
        <input class="form-control" type="text" name="name" placeholder="Name" aria-required="true" aria-invalid="true">
    </div>
    <div class="clearfix"></div>
    <div class="col-md-4">
        <label>Relation*</label>
        <select class="form-control" name="relation" aria-required="true" aria-invalid="true" v-model="patient_gender">
            <option selected="" disabled="">Select Relation</option>
            <option value="Male">Friend</option>
            <option value="Female">Relative</option>
        </select>
    </div>
    <div class="col-md-4">
        <label>Mobile Number*</label>
        <input class="form-control" type="text" name="mobile_number" placeholder="Mobile Number" aria-required="true" aria-invalid="true" >
    </div>
    <div class="clearfix"></div>
     <div class="col-md-4">
        <label>Address*</label>
        <textarea class="form-control" type="text" name="address" placeholder="Address" aria-required="true" aria-invalid="true" ></textarea>
    </div>
   
     

</div>
