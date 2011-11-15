<?php
/**
 *
 * ThinkUp/webapp/_lib/model/class.ActiveUsersCountMySQLDAO.php
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
 * Active Users Count MySQL Data Access Object implementation
 *
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2011 SwellPath, Inc.
 * @author Christian G. Warden <cwarden[at]xerus[dot]org>
 *
 */
class ActiveUsersCountMySQLDAO extends PDODAO implements ActiveUsersCountDAO {
    public function upsert($instance_id, $date, $period = 'day', $count) {
        $q  = "REPLACE INTO #prefix#active_users ";
        $q .= "(instance_id, date, period, count) ";
        $q .= "VALUES ( :instance_id, :date, :period, :count );";
        $vars = array(
            ':instance_id'=>$instance_id,
            ':date'=>$date,
            ':period'=>$period,
            ':count'=>$count
        );
        if ($this->profiler_enabled) Profiler::setDAOMethod(__METHOD__);
        $ps = $this->execute($q, $vars);
        return $this->getInsertCount($ps);
    }

    public function getEarliest($instance_id) {
        $q = "SELECT UNIX_TIMESTAMP(MIN(date)) AS earliest FROM #prefix#active_users ";
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
        $q = "SELECT UNIX_TIMESTAMP(MAX(date)) AS latest FROM #prefix#active_users ";
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

}

