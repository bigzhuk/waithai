<?php

namespace News\Decorator;

class NewsEsksFront extends News {
    public function renderNewsTable(array $new_rows) {
        $out = '';
        foreach ($new_rows as $new_row) {
            $out.= '
            <div id="news_list">
                <div class="news_item">
                    <div class="date">'.$this->dateRusFormat($new_row['date_publish_start']).'</div>
                    <div class="title">'.$new_row['title'].'</div>
                    <div class="content">'.$new_row['full_text'].'</div>
                </div>
            </div>
        ';
        }

        return $out;
    }

    public function dateRusFormat($date = FALSE) {
        if(!$date) {
            $date = time();
        }
        $month_number = date('n', $date);
        switch ($month_number) {
            case 1: $rus = 'января'; break;
            case 2: $rus = 'февраля'; break;
            case 3: $rus = 'марта'; break;
            case 4: $rus = 'апреля'; break;
            case 5: $rus = 'мая'; break;
            case 6: $rus = 'июня'; break;
            case 7: $rus = 'июля'; break;
            case 8: $rus = 'августа'; break;
            case 9: $rus = 'сентября'; break;
            case 10: $rus = 'октября'; break;
            case 11: $rus = 'ноября'; break;
            case 12: $rus = 'декабря'; break;
            default: $rus = 'января'; break;
        }
        return date('d').' '.$rus.' '.date('Y');
    }
}