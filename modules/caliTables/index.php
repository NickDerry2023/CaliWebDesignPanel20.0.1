<?php
    if ($_SESSION['graphCallType'] == "Dashboard Tasks Table") {
        $sql = "SELECT * FROM caliweb_tasks";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Output table header
            echo '<table style="width:100%; margin-top:1%;">
                    <tr>
                        <th style="width:20%; font-size:12px;">Task Name</th>
                        <th style="width:20%; font-size:12px;">Task Start Date</th>
                        <th style="width:20%; font-size:12px;">Task Due Date</th>
                        <th style="width:20%; font-size:12px;">Status</th>
                    </tr>';

            // Output table rows
            while ($row = mysqli_fetch_assoc($result)) {

                $tasksStatusColorAssignment = $row['status'];

                echo '<tr>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['taskName'] . '</td>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['taskStartDate'] . '</td>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['taskDueDate'] . '</td>';
                    if ($tasksStatusColorAssignment == "Completed" || $tasksStatusColorAssignment == "Completed") {
                        echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge green" style="margin-left:0;">' . $row['status'] . '</span></td>';
                    } else if ($tasksStatusColorAssignment == "Overdue" || $tasksStatusColorAssignment == "overdue") {
                       echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge red" style="margin-left:0;">' . $row['status'] . '</span></td>';
                    } else if ($tasksStatusColorAssignment == "Pending" || $tasksStatusColorAssignment == "pending") {
                       echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge yellow" style="margin-left:0;">' . $row['status'] . '</span></td>';
                    } else if ($tasksStatusColorAssignment == "Stuck" || $tasksStatusColorAssignment == "stuck") {
                       echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge red-dark" style="margin-left:0;">' . $row['status'] . '</span></td>';
                    }
                echo '</tr>';

            }

            echo '</table>';
        }
    } else if ($_SESSION['graphCallType'] == "Dashboard Cases Table") {
        $sql = "SELECT * FROM caliweb_cases";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Output table header
            echo '<table style="width:100%; margin-top:1%;">
                    <tr>
                        <th style="width:20%; font-size:12px;">Customer Name</th>
                        <th style="width:20%; font-size:12px;">Case Title</th>
                        <th style="width:20%; font-size:12px;">Case Created</th>
                        <th style="width:20%; font-size:12px;">Case Closed</th>
                        <th style="width:20%; font-size:12px;">Status</th>
                    </tr>';

            // Output table rows
            while ($row = mysqli_fetch_assoc($result)) {

                $caseStatusColorAssignment = $row['caseStatus'];

                echo '<tr>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['customerName'] . '</td>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['caseTitle'] . '</td>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['caseCreateDate'] . '</td>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['caseCloseDate'] . '</td>';
                    if ($caseStatusColorAssignment == "Open" || $caseStatusColorAssignment == "open") {
                        echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge green" style="margin-left:0;">' . $row['caseStatus'] . '</span></td>';
                    } else if ($caseStatusColorAssignment == "Closed" || $caseStatusColorAssignment == "closed") {
                       echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge passive" style="margin-left:0;">' . $row['caseStatus'] . '</span></td>';
                    } else if ($caseStatusColorAssignment == "Pending" || $caseStatusColorAssignment == "pending") {
                       echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge yellow" style="margin-left:0;">' . $row['caseStatus'] . '</span></td>';
                    } else if ($caseStatusColorAssignment == "On Hold" || $caseStatusColorAssignment == "on hold") {
                       echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge red" style="margin-left:0;">' . $row['caseStatus'] . '</span></td>';
                    }
                echo '</tr>';

            }

            echo '</table>';
        }
    } else if ($_SESSION['graphCallType'] == "Dashboard Tasks Table Employee Only") {
        $sql = "SELECT * FROM caliweb_tasks WHERE assignedUser = '$fullname'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Output table header
            echo '<table style="width:100%; margin-top:1%;">
                    <tr>
                        <th style="width:20%; font-size:12px;">Task Name</th>
                        <th style="width:20%; font-size:12px;">Task Start Date</th>
                        <th style="width:20%; font-size:12px;">Task Due Date</th>
                        <th style="width:20%; font-size:12px;">Status</th>
                    </tr>';

            // Output table rows
            while ($row = mysqli_fetch_assoc($result)) {

                $tasksStatusColorAssignment = $row['status'];

                echo '<tr>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['taskName'] . '</td>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['taskStartDate'] . '</td>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['taskDueDate'] . '</td>';
                    if ($tasksStatusColorAssignment == "Completed" || $tasksStatusColorAssignment == "Completed") {
                        echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge green" style="margin-left:0;">' . $row['status'] . '</span></td>';
                    } else if ($tasksStatusColorAssignment == "Overdue" || $tasksStatusColorAssignment == "overdue") {
                       echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge red" style="margin-left:0;">' . $row['status'] . '</span></td>';
                    } else if ($tasksStatusColorAssignment == "Pending" || $tasksStatusColorAssignment == "pending") {
                       echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge yellow" style="margin-left:0;">' . $row['status'] . '</span></td>';
                    } else if ($tasksStatusColorAssignment == "Stuck" || $tasksStatusColorAssignment == "stuck") {
                       echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge red-dark" style="margin-left:0;">' . $row['status'] . '</span></td>';
                    }
                echo '</tr>';

            }

            echo '</table>';
        }
    } else if ($_SESSION['graphCallType'] == "Dashboard Cases Table") {
        $sql = "SELECT * FROM caliweb_cases WHERE assignedAgent = '$fullname'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Output table header
            echo '<table style="width:100%; margin-top:1%;">
                    <tr>
                        <th style="width:20%; font-size:12px;">Customer Name</th>
                        <th style="width:20%; font-size:12px;">Case Title</th>
                        <th style="width:20%; font-size:12px;">Case Created</th>
                        <th style="width:20%; font-size:12px;">Case Closed</th>
                        <th style="width:20%; font-size:12px;">Status</th>
                    </tr>';

            // Output table rows
            while ($row = mysqli_fetch_assoc($result)) {

                $caseStatusColorAssignment = $row['caseStatus'];

                echo '<tr>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['customerName'] . '</td>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['caseTitle'] . '</td>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['caseCreateDate'] . '</td>';
                    echo '<td style="width:20%; font-size:12px;">' . $row['caseCloseDate'] . '</td>';
                    if ($caseStatusColorAssignment == "Open" || $caseStatusColorAssignment == "open") {
                        echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge green" style="margin-left:0;">' . $row['caseStatus'] . '</span></td>';
                    } else if ($caseStatusColorAssignment == "Closed" || $caseStatusColorAssignment == "closed") {
                       echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge passive" style="margin-left:0;">' . $row['caseStatus'] . '</span></td>';
                    } else if ($caseStatusColorAssignment == "Pending" || $caseStatusColorAssignment == "pending") {
                       echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge yellow" style="margin-left:0;">' . $row['caseStatus'] . '</span></td>';
                    } else if ($caseStatusColorAssignment == "On Hold" || $caseStatusColorAssignment == "on hold") {
                       echo '<td style="width:20%; font-size:12px;"><span class="account-status-badge red" style="margin-left:0;">' . $row['caseStatus'] . '</span></td>';
                    }
                echo '</tr>';

            }

            echo '</table>';
        }
    }
?>