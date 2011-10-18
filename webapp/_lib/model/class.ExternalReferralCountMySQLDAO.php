<?php
/**
 *
 * ThinkUp/webapp/_lib/model/class.ExternalReferralCountMySQLDAO.php
 *
 * Copyright (c) 2011 SwellPath, Inc.
 *
 * LICENSE:
 *
 * This file is part of ThinkUp (http://thinkupapp.com).
 *
 * ThinkUp is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any
 * later version.
 *
 * ThinkUp is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with ThinkUp.  If not, see
 * <http://www.gnu.org/licenses/>.
 *
 *
 * External Referral Count MySQL Data Access Object implementation
 *
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2011 SwellPath, Inc.
 * @author Christian G. Warden <cwarden[at]xerus[dot]org>
 *
 */
class ExternalReferralCountMySQLDAO extends PDODAO implements ExternalReferralCountDAO {
    public function upsert($instance_id, $domain_id, $date, $count){
        $q  = "REPLACE INTO #prefix#referrals ";
        $q .= "(instance_id, domain_id, date, referrals) ";
        $q .= "VALUES ( :instance_id, :domain_id, :date, :count );";
        $vars = array(
            ':instance_id'=>$instance_id,
            ':domain_id'=>$domain_id,
            ':date'=>$date,
            ':count'=>$count
        );
        if ($this->profiler_enabled) Profiler::setDAOMethod(__METHOD__);
        $ps = $this->execute($q, $vars);
        return $this->getInsertCount($ps);
    }

    public function getEarliest($instance_id) {
        $q = "SELECT UNIX_TIMESTAMP(MIN(date)) AS earliest FROM #prefix#referrals ";
        $q .= "WHERE instance_id = :instance_id";
        $vars = array(
            ':instance_id'=> $instance_id
        );
        if ($this->profiler_enabled) Profiler::setDAOMethod(__METHOD__);
        $ps = $this->execute($q, $vars);
        $row = $this->fetchAndClose($ps);
        if (! $row) {
            return null;
        }
        return $row['earliest'];
    }

    public function getLatest($instance_id) {
        $q = "SELECT UNIX_TIMESTAMP(MAX(date)) AS latest FROM #prefix#referrals ";
        $q .= "WHERE instance_id = :instance_id";
        $vars = array(
            ':instance_id'=> $instance_id
        );
        if ($this->profiler_enabled) Profiler::setDAOMethod(__METHOD__);
        $ps = $this->execute($q, $vars);
        $row = $this->fetchAndClose($ps);
        if (! $row) {
            return null;
        }
        return $row['latest'];
    }

    public function getHistory($network_user_id, $network, $units, $top_domains = 10, $periods_limit=10) {
        if ($units != "DAY" && $units != 'WEEK' && $units != 'MONTH') {
            $units = 'DAY';
        }
        $periods_limit = intval($periods_limit);
        if ($units == 'DAY') {
            $group_by = 'r.date';
        } else if ($units == 'WEEK') {
            $group_by = 'YEAR(r.date), WEEK(r.date)';
        } else if ($units == 'MONTH') {
            $group_by = 'YEAR(r.date), MONTH(r.date)';
        }
        $q = "
          SELECT
            data.full_date,
            data.date,
            data.domain,
            data.referrals
          FROM
            /* Main Table containing data */
            (SELECT
              r.date AS full_date,
              DATE_FORMAT(r.date, '%c/%e/%y') AS date,
              SUM(r.referrals) AS referrals,
              r.domain_id,
              d.domain
            FROM
              #prefix#referrals r
            INNER JOIN
              #prefix#domains d
            ON
              r.domain_id = d.id
            INNER JOIN
              #prefix#instances i
            ON
              (i.id = r.instance_id AND
              i.network_user_id = :network_user_id AND
              i.network = :network)
            WHERE
              r.date >= DATE_SUB(NOW(), INTERVAL $periods_limit $units)
            GROUP BY
              $group_by, r.domain_id
          ) AS data
          INNER JOIN
            /* Table containing only top $top_domains domains for last $periods_limit dates */
            (SELECT
              domain_id,
              SUM(referrals) as referrals
            FROM
              #prefix#referrals r
            INNER JOIN
              #prefix#domains d
            ON
              r.domain_id = d.id
            INNER JOIN
              #prefix#instances i
            ON
              (i.id = r.instance_id AND
              i.network_user_id = :network_user_id AND
              i.network = :network)
            WHERE
              domain NOT IN ('www.facebook.com', 'facebook.com') AND /* why are these coming through the API */
              r.date >= DATE_SUB(NOW(), INTERVAL $periods_limit $units)
            GROUP BY
              domain_id
            ORDER BY
              referrals DESC
            LIMIT :top_domains
          ) AS limited_domains
          WHERE
            limited_domains.domain_id = data.domain_id
          ORDER BY
            data.full_date ASC";
        $vars = array(
            ':network_user_id'=>(string) $network_user_id,
            ':network'=>$network,
            ':top_domains' => $top_domains,
        );
        if ($this->profiler_enabled) Profiler::setDAOMethod(__METHOD__);
        $ps = $this->execute($q, $vars);
        $history_rows = $this->getDataRowsAsArrays($ps);
        $resultset = array();
        foreach ($history_rows as $row) {
          $resultset[] = array($row['domain'], $row['full_date'], $row['referrals']);
        }
        $metadata = array(
          array('colIndex' => 0, 'colType' => 'String', 'colName' => 'Series'),
          array('colIndex' => 1, 'colType' => 'String', 'colName' => 'Categories'),
          array('colIndex' => 2, 'colType' => 'Numeric', 'colName' => 'Value'),
        );
        return json_encode(array('resultset' => $resultset, 'metadata' => $metadata));
    }

}
