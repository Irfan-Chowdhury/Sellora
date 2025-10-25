      <!-- Sidebar Menu -->
      <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                  <a href="{{ url('admin/dashboard') }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>
                          Dashboard
                      </p>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-book"></i>
                      <p>
                        Product Hub
                          <i class="fas fa-angle-left right"></i>
                      </p>
                  </a>
                  <ul class="nav nav-treeview">
                      <li class="nav-item">
                          <a href="{{ route('admin.category') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Category</p>
                          </a>
                      </li>
                  </ul>
              </li>
              <li class="nav-item">
                  <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-book"></i>
                      <p>
                        Access Control
                          <i class="fas fa-angle-left right"></i>
                      </p>
                  </a>
                  <ul class="nav nav-treeview">
                      <li class="nav-item">
                          <a href="{{ route('admin.roles.index') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Role Manage</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('admin.category') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Assign Role</p>
                          </a>
                      </li>
                  </ul>
              </li>




          </ul>
      </nav>
      <!-- /.sidebar-menu -->
