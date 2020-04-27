@extends('website.app')

@section('title')
Partners
@endsection

@section('body-id'){{'about-us'}}@endsection

@section('content')
<section class="box-with-image-right section-top-space">
    
        <div class="center">
            <div class="clear"></div>
            <div class="content">

                <h2>List of Partners</h2>
                
                <table class="display" id="partners">
              <thead>
                <tr>
                    <td></td>
                    <th>Name of Associate</th>
                </tr>
              </thead>
              <tbody style="text-align:center;">
                 
               @foreach($associatePartners as $associatePartner)
                <tr>
                   <td></td>
                   <td>{{$associatePartner}}</td>
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