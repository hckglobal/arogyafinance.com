<li class="active">
  <a href="#"><i class="fa fa-circle-o"></i>New Card Applications
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu menu-open" style="display: block;">
    <li>
      <li class="{{Request::is('admin/application/card/one/new/index')? 'active': ''}}"><a href="/admin/application/card/one/new/index"><i class="fa fa-circle-o"></i> Category One</a></li>
      <li class="{{Request::is('admin/application/card/two/new/index')? 'active': ''}}"><a href="/admin/application/card/two/new/index"><i class="fa fa-circle-o"></i> Category Two</a></li>
      <li class="{{Request::is('admin/application/card/three/new/index')? 'active': ''}}"><a href="/admin/application/card/three/new/index"><i class="fa fa-circle-o"></i> Category Three</a></li>
    </li>
  </ul>
</li>
