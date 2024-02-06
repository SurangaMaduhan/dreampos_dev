<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Main</h6>
                    <ul>
                        <li class="active">
                            <a href="/"><i data-feather="grid"></i><span>Dashboard</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Products</h6>
                    <ul>
                        <li><a href="/products-list/"><i data-feather="box"></i><span>Products</span></a></li>
                        <li><a href="/add-products/"><i data-feather="plus-square"></i><span>Create Product</span></a>
                        </li>
                        <li><a href="/category-list/"><i data-feather="codepen"></i><span>Category</span></a></li>
                        <li><a href="/brand-list/"><i data-feather="tag"></i><span>Brands</span></a></li>
                        <li><a href="/import-product/"><i data-feather="minimize-2"></i><span>Import Products</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Sales</h6>
                    <ul>
                        <li><a href="/point-of-sale/"><i data-feather="hard-drive"></i><span>POS</a></li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="shopping-cart"></i><span>Sales</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="/sales/"><span>All Sales</span></a></li>
                                <li><a href="/pending-sales/"><span>Pending Sales</span></a></li>
                                <li><a href="/completed-sales/"><span>Completed Sales</span></a></li>
                                <li><a href="/canceled-sales/"><span>Canceled Sales</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Reload</h6>
                    <ul>
                        <li><a href="/reload-list/"><i data-feather="send"></i><span>Reload list</span></a></li>
                        <li><a href="/reload-provider-list/"><i data-feather="globe"></i><span>Reload Providers</span></a></li>
                        
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Topup Cards</h6>
                    <ul>
                        <li><a href="/cards/"><i data-feather="send"></i><span>Card Sales</span></a></li>
                        <li><a href="/cards-list/"><i data-feather="globe"></i><span>Cards List</span></a></li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Purchases</h6>
                    <ul>
                        <li><a href="/import-purchase/"><i data-feather="minimize-2"></i><span>Import
                                    Purchases</span></a></li>

                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">User Management</h6>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i data-feather="users"></i><span>Manage Users</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="/add-user/">New User </a></li>
                                <li><a href="/users-list/">Users List</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Settings</h6>
                    <ul>
                        <li>
                            <a href="<?php echo wp_logout_url(get_permalink()); ?>"><i data-feather="log-out"></i><span>Logout</span> </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->