@extends('website.app')

@section('title')
Hospital Partners
@endsection

@section('body-id'){{'about-us'}}@endsection

@section('content')
<section class="box-with-image-right section-top-space">
    
        <div class="center">
            <div class="clear"></div>
            <div class="content">

                <h2>List of Hospital Tie-ups</h2>
                
                <table class="display" id="partners">
              <thead>
                <tr>
                    <td></td>
                    <th>Name of Hospital</th>
                    <th>Location</th>
                    <th>No of Hospitals</th>
                </tr>
              </thead>
              <tbody style="text-align:center;">
                 
               @foreach($hospitals as $hospital)
                <tr>
                   <td></td>
                   <td><a href="{{$hospital->url}}" target="_blank">{{$hospital->name}}</a></td>
                   <td>{{$hospital->location}}</td>
                   <td>{{$hospital->branches}}</td>
                </tr>
                @endforeach

                </tbody>
              </table>
                    
        </div>
    
    </section>
@endsection

@section('scripts')
<script type="text/javascript">

</script>
@endsection