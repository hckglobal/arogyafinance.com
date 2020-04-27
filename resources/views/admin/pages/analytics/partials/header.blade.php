
<div class="col-md-4">
    <div class="form-group">
        <label for="start_date">From</label>
        <div class='input-group date' id='start_date'>
            <input type='text' class="form-control" name="start_date"
                @if($input->start_date!=null)
                    value="{{$input->start_date}}"
                @endif
            >
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>   
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="end_date">To</label>
        <div class='input-group date' id='end_date'>
            <input type='text' class="form-control" name="end_date"
                @if($input->end_date!=null)
                    value="{{$input->end_date}}"
                @endif
            >
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>   
</div>

<div class="col-md-4">
    <div class="form-group contact-search m-b-30">
        <label for="month">Status</label>
        <select class="form-control" name="status">
            <option value="" disabled selected>Select status</option>
            <option @if($input->status == "all")) selected @endif value="all">All</option>
            @if($title=='MIS Summary')
                <option @if($input->status == "converted-to-card") selected @endif value="converted-to-card">Converted Card</option>
                <option @if($input->status == "converted-to-loan") selected @endif value="converted-to-loan">Converted Loan</option>
                <option @if($input->status == "pending")selected @endif value="pending">Pending</option>
                <option @if($input->status == "rejected") selected @endif value="rejected">Rejected
                </option>
            @else
                <option @if($input->status == "lead") selected @endif 
                value="lead">Lead
                </option>
                <option @if($input->status == "new") selected @endif 
                value="new">New
                </option>
                <option @if($input->status == "verified") selected @endif 
                value="verified">Verified
                </option>
                <option @if($input->status == "sanctioned") selected @endif 
                value="sanctioned">Sanctioned
                </option>
                <option @if($input->status == "disbursed" || $input->prefix == "disbursed") selected @endif 
                value="disbursed">Disbursed
                </option>
                <option @if($input->status == "closed") selected @endif 
                value="closed">Closed
                </option>
                <option @if($input->status == "disbursed_closed") selected @endif 
                value="disbursed_closed">Disbursed & Closed
                </option>
                <option @if($input->status == "rejected") selected @endif 
                value="rejected">Rejected
                </option>
            @endif
            <option @if($input->reject_reason_id == "1" || $input->status == "1") selected @endif 
            value="1">Criteria Not met
            </option>
            <option @if($input->reject_reason_id == "7" || $input->status == "7") selected @endif 
            value="7">Enquiries Pending /Follow Up
            </option>
            <option @if($input->reject_reason_id == "8" || $input->status == "8") selected @endif 
            value="8">Insufficient Income
            </option>
            <option @if($input->reject_reason_id == "2" || $input->status == "2") selected @endif 
            value="2">Just Enquiry
            </option>
            <option @if($input->reject_reason_id == "6" || $input->status == "6") selected @endif 
            value="6">Not interested in Surgery
            </option>
            <option @if($input->reject_reason_id == "9" || $input->status == "9") selected @endif 
            value="9">Not Interested
            </option>
            <option @if($input->reject_reason_id == "10" || $input->status == "10") selected @endif 
            value="10">Not interested in Finance
            </option>
            <option @if($input->reject_reason_id == "3" || $input->status == "3") selected @endif 
            value="3">Paid In cash
            </option>
            <option @if($input->reject_reason_id == "11" || $input->status == "11") selected @endif 
            value="11">Sanction but not Availed
            </option>
            <option @if($input->reject_reason_id == "12" || $input->status == "12") selected @endif 
            value="12">Sanctioned and Pending Disbursal
            </option>
            <option @if($input->reject_reason_id == "5" || $input->status == "5") selected @endif 
            value="5">Used Other brand device
            </option>
        </select>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group contact-search m-b-30">
        <label for="location">Location</label>
        <select class="form-control" name="location">
            <option value="" disabled selected>Select location</option>
            <option @if($input->location == "all")) selected @endif value="all">All</option>
            @foreach($locations as $location)
            <option @if($input->location == $location->id) selected @endif 
              value="{{$location->id}}">{{$location->name}}
            </option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group contact-search m-b-30">
        <label for="product">Product</label>
        <select class="form-control" name="product">
            <option value="" disabled selected>Select Product</option>
            <option @if($input->product == "all")) selected @endif value="all">All</option>
            @foreach($products as $product)
            <option @if($input->product == $product->id) selected @endif 
              value="{{$product->id}}">{{$product->name}}
            </option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group contact-search m-b-30">
        <label>&nbsp;</label>
        <button type="submit" class="btn btn-block btn-primary">
            <i class="ion-funnel">&nbsp;&nbsp;</i> Filter
        </button>
    </div>
</div>
<div class="col-md-2">
    <div class="">
        <label>&nbsp;</label>
        @if($title=='MIS Summary')
            <a href="/admin/analytics/mis/summary" class="btn btn-block btn-primary">Clear Filter</a>    
        @elseif($input->type=='loan')
            <a href="/admin/analytics/summary?type=loan" class="btn btn-block btn-primary">Clear Filter</a>
        @elseif($input->type=='card')
            <a href="/admin/analytics/summary?type=card" class="btn btn-block btn-primary">Clear Filter</a>
        @else
        <a href="/admin/analytics/summary" class="btn btn-block btn-primary">Clear Filter</a>    
        @endif
    </div>
</div>
<div class="col-md-2 pull-right">
    <div class="form-group contact-search m-b-30">
        <label>&nbsp;</label>
        @if($title=='MIS Summary')
            <a class="btn btn-block btn-primary" 
                href="/admin/analytics/mis/summary/export?{{$input->getQueryString()}}">
                <i class="ion-archive">&nbsp;&nbsp;</i>Export
            </a>    
        @elseif($input->type=='loan')
            <a class="btn btn-block btn-primary" 
                href="/admin/analytics/summary/export?{{$input->getQueryString()}}&type=loan">
                <i class="ion-archive">&nbsp;&nbsp;</i>Export
            </a>
        @elseif($input->type=='card')
            <a class="btn btn-block btn-primary" 
                href="/admin/analytics/summary/export?{{$input->getQueryString()}}&type=card">
                <i class="ion-archive">&nbsp;&nbsp;</i>Export
            </a>
        @else
            <a class="btn btn-block btn-primary" href="/admin/analytics/summary/export?{{$input->getQueryString()}}">
                <i class="ion-archive">&nbsp;&nbsp;</i>Export
            </a>
        @endif        
    </div>
</div>
@section('scripts')           
<script type="text/javascript">
    $(document).ready(function() {
        $('#start_date').datetimepicker({
            locale: 'en',
            format: 'DD-MM-YYYY'          
        });

        $('#end_date').datetimepicker({
            locale: 'en',
            format: 'DD-MM-YYYY'            
        });
    });
</script>
@endsection