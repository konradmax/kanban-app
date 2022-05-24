<?php
declare(strict_types=1);

namespace App\News\Domain;

use App\Common\Domain\CommonModel;

class FilterModel extends NewsModel
{

    public function filterByDateAndTags($dateStart=null,$dateEnd=null,$tag=null)
    {

        $sql = sprintf(
            "SELECT * 
                                FROM %s 
                                 ",
            $this->table
        );

        if(!empty($tag)) {
            $sql .= " LEFT JOIN news_tags ON news.id=news_tags.news_id WHERE news_tags.tags_id = " . $tag;
        }


        if(empty($dateStart) XOR empty($dateEnd)) {
            if(empty($dateStart)) {
                // dateStart is NOT empty
                $sql .= ($tag)?" AND ":" WHERE ";
                $sql .= sprintf(" news.date_created < '%s'", $dateEnd . ' 00:00:00');
            } else {
                // dateEnd is NOT empty
                $sql .= ($tag)?" AND ":" WHERE ";
                $sql .= sprintf(" news.date_created > '%s'", $dateStart . ' 00:00:00');
            }
        } elseif(! empty($dateStart)) {
            $sql .= ($tag)?" AND ":" WHERE ";
            $sql .= sprintf(" news.date_created BETWEEN '%s' AND '%s'", $dateStart . ' 00:00:00', $dateEnd . ' 00:00:00');
        }

        return $this->database->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
