<li class="active">
  <a href="#"><i class="fa fa-circle-o"></i>Verified Loan Applications
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu menu-open" style="display: block;">
    <li>
      <li class="{{Request::is('admin/application/loan/one/verified/index')? 'active': ''}}"><a href="/admin/application/loan/one/verified/index"><i class="fa fa-circle-o"></i> Category One</a></li>
      <li class="{{Request::is('admin/application/loan/two/verified/index')? 'active': ''}}"><a href="/admin/application/loan/two/verfied/index"><i class="fa fa-circle-o"></i> Category Two</a></li>
      <li class="{{Request::is('admin/application/loan/three/verified/index')? 'active': ''}}"><a href="/admin/application/loan/three/verfied/index"><i class="fa fa-circle-o"></i> Category Three</a></li>
    </li>
  </ul>
</li>
