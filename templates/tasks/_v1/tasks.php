sss
<div class="container-fluid pt-3">
    <h3 class="font-weight-light text-white">Kanban Board</h3>
    <?php include('messages.php');?>
    <div class="row flex-row py-3">
        <div class="col-3">
            <form method="POST" name="new_task" action="?page=tasks&action=create">
                <input type="hidden" name="form_name" value="new_task" />
                <input class="btn btn-primary" value="New Task" type="submit"/>
            </form>
        </div>
    </div>
    <form method="POST" action="?page=tasks&action=update">
        <input type="hidden" name="form_name" value="swimlane_update" />
        <input type="submit" name="" class="btn btn-primary" />
    <div class="row flex-row py-3">
        <div class="col-sm-6 col-md-3 col-xl-3">
            <div class="card bg-light card-swimlane" data-status-value="1">
                <div class="card-body">
                    <h6 class="card-title text-uppercase text-truncate py-2">To Do</h6>
                    <div class="items border border-light">
                        <?php
                        $tasksTodo = $content['tasks'][1];
                        if( ! empty($tasksTodo)) {
                            foreach($tasksTodo as $taskTodo):
                                include("templates/swimlane-item.php");
                            endforeach;
                        }
                        ?>
                        <div class="dropzone rounded" ondrop="drop(event);updateInputStatusDrop(this);iterateSwimlanes();" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xl-3">
            <div class="card bg-light card-swimlane" data-status-value="2">
                <div class="card-body">
                    <h6 class="card-title text-uppercase text-truncate py-2">In-progess</h6>
                    <div class="items border border-light">
                        <?php
                        $tasksTodo = $content['tasks'][2];
                        if( ! empty($tasksTodo)) {
                            foreach($tasksTodo as $taskTodo):
                                include("templates/swimlane-item.php");
                            endforeach;
                        }
                        ?>
                        <div class="dropzone rounded" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-6 col-md-3 col-xl-3">
            <div class="card bg-light card-swimlane" data-status-value="3">
                <div class="card-body">
                    <h6 class="card-title text-uppercase text-truncate py-2">Review</h6>
                    <div class="items border border-light">
                        <?php
                        $tasksTodo = $content['tasks'][3];
                        if( ! empty($tasksTodo)) {
                            foreach($tasksTodo as $taskTodo):
                                include("templates/swimlane-item.php");
                            endforeach;
                        }
                        ?>
                        <div class="dropzone rounded" ondrop="drop(event);updateInputStatusDrop(this)" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xl-3">
            <div class="card card-swimlane"  data-status-value="4">
                <div class="card-body">
                    <h6 class="card-title text-uppercase text-truncate py-2">Complete</h6>
                    <div class="items border border-light">
                        <?php
                        $tasksTodo = $content['tasks'][4];
                        if( ! empty($tasksTodo)) {
                            foreach($tasksTodo as $taskTodo):
                                include("templates/swimlane-item.php");
                            endforeach;
                        }
                        ?>
                        <div class="dropzone rounded" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </form>

</div>

