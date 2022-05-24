<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Kanban App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <?php if(isset($is_logged_in)&&$is_logged_in===true):?>
                        <li class="nav-item">
                            <a class="nav-link p-2" href="/tasks">Tasks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-2" href="/news">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-2" href="/logout" aria-disabled="true">Logout</a>
                        </li>
                    <?php else:?>
                        <li class="nav-item">
                            <a class="nav-link p-2" href="/login" aria-disabled="true">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-2 " href="/register" aria-disabled="true">Register</a>
                        </li>
                    <?php endif;?>
                </ul>
                    <div class="col-md-3 text-end">
                        <?php if(isset($is_admin)&&$is_admin):?>
                            <a class="btn btn-success p-2 mx-3" href="/tasks/create" aria-disabled="true">Create Task</a>
                            <a class="btn btn-success p-2" href="/news/create" aria-disabled="true">Create News</a>
                        <?php endif;?>
                    </div>
            </div>
        </div>
    </nav>
</header>