<div class="invoice-custom">
  
   <table class="table">
    <thead>
      <tr>
        <th>Description</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td width="40%">
          <h4>Processing Fee</h4>
        </td>
        <td width="20%"><span>&#8377; 500</span></td>
      </tr>
      <tr>
        <td width="40%">
          <h4>Document Charges</h4>
        </td>
        <td width="20%"><span>&#8377; 500</span></td>
      </tr>
     
    </tbody>
  </table>
  <div class="total-amount-display pull-right">
    <div class="subtotal">
      
      @if($application->type == 'loan')
        <p><span>Subtotal  </span>: &#8377; 1000</p>
        <p><span>GST  </span>: 18% (&#8377; 180)</p>
        <p><span>Grand Total  </span>: &#8377; 1180</p>
      @else
        <p><span>Grand Total  </span>: &#8377; 1000</p>
      @endif
    </div>
  </div>
  <div class="clearfix"></div>
</div>