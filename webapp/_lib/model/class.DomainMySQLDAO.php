<?php
/**
 *
 * ThinkUp/webapp/_lib/model/class.DomainMySQLDAO.php
 *
 * Copyright (c) 2011 SwellPath, INc.
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
 * Domain MySQL Data Access Object implementation
 *
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2011 SwellPath, Inc.
 * @author Christian G. Warden <cwarden[at]xerus[dot]org>
 *
 */
class DomainMySQLDAO extends PDODAO implements DomainDAO {
    public function domainExists($domain) {
        $q = "SELECT id, domain ";
        $q .= "FROM #prefix#domains ";
        $q .= "WHERE domain = :domain ";
        $vars = array(
            ':domain'=>(string)$domain, 
        );
        if ($this->profiler_enabled) Profiler::setDAOMethod(__METHOD__);
        $ps = $this->execute($q, $vars);

        return $this->getDataIsReturned($ps);
    }

    public function insert($domain) {
        $q  = "INSERT INTO #prefix#domains ";
        $q .= "(domain) ";
        $q .= "VALUES ( :domain );";
        $vars = array(
            ':domain'=>(string)$domain, 
        );
        if ($this->profiler_enabled) Profiler::setDAOMethod(__METHOD__);
        $ps = $this->execute($q, $vars);

        return $this->getInsertCount($ps);
    }

    public function getDomain($domain) {
        if (! $this->domainExists($domain)) {
            $this->insert($domain);
        }
        $q = "SELECT id, domain ";
        $q .= "FROM #prefix#domains ";
        $q .= "WHERE domain = :domain ";
        $vars = array(
            ':domain'=>$domain,
        );
        if ($this->profiler_enabled) Profiler::setDAOMethod(__METHOD__);
        $ps = $this->execute($q, $vars);
        return $this->getDataRowAsObject($ps, "Domain");
    }

}

