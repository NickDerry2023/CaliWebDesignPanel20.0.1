<?php

    function fetchAndDisplayTable($con, $sql, $headers, $columns, $columnWidths, $actionUrls = []) {

        try {

            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {

                echo '<table style="width:100%;">';
                echo renderTableHeaders($headers, $columnWidths);

                while ($row = mysqli_fetch_assoc($result)) {

                    echo renderTableRow($row, $columns, $columnWidths, $actionUrls);

                }

                echo '</table>';

            } else {

                echo '<p class="no-padding font-14px" style="margin-top:-2% !important; margin-bottom:25px;">No records found.</p>';

            }

            mysqli_free_result($result);

        } catch (\Throwable $exception) {
            
            \Sentry\captureException($exception);
            
        }   

    }

    function renderTableHeaders($headers, $columnWidths) {

        try {

            $headerHtml = '<tr>';

            foreach ($headers as $index => $header) {

                $width = isset($columnWidths[$index]) ? $columnWidths[$index] : 'auto';
                $headerHtml .= "<th style='width:{$width};'>{$header}</th>";

            }

            $headerHtml .= '</tr>';
            return $headerHtml;

        } catch (\Throwable $exception) {
            
            \Sentry\captureException($exception);
            
        }

    }

    function renderTableRow($row, $columns, $columnWidths, $actionUrls) {

        try {

            $rowHtml = '<tr>';

            foreach ($columns as $index => $column) {

                $width = isset($columnWidths[$index]) ? $columnWidths[$index] : 'auto';
                $rowHtml .= "<td style='width:{$width};'>{$row[$column]}</td>";
                
            }

            if ($actionUrls) {

                $rowHtml .= renderActionUrls($row, $actionUrls);

            }

            $rowHtml .= '</tr>';
            return $rowHtml;

        } catch (\Throwable $exception) {
            
            \Sentry\captureException($exception);
            
        }

    }

    function renderActionUrls($row, $actionUrls) {

        try {

            $actionHtml = '<td style="width: auto; display:flex; align-items:center;">';

            foreach ($actionUrls as $action => $urlTemplate) {

                $actionUrl = $urlTemplate;

                foreach ($row as $key => $value) {

                    $actionUrl = str_replace('{' . $key . '}', $value, $actionUrl);

                }

                $actionHtml .= "<a href='{$actionUrl}' style='margin-right:10px;' class='careers-link'>{$action}</a>";
                
            }

            $actionHtml .= '</td>';
            return $actionHtml;

        } catch (\Throwable $exception) {
            
            \Sentry\captureException($exception);
            
        }

    }

?>