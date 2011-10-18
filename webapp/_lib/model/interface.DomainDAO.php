<?php
/**
 *
 * ThinkUp/webapp/_lib/model/interface.DomainDAO.php
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
 * Domain Data Access Object interface
 *
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2011 SwellPath, Inc.
 * @author Christian G. Warden <cwarden[at]xerus[dot]org>
 *
 */
interface DomainDAO {
    /**
     * Check if a domain is in the database
     * @param str $domain
     * @return bool True if yes, false if not
     */
    public function domainExists($domain);

    /**
     * Adds a domain to storage
     * @param str $domain
     * @return int insert count
     */
    public function insert($domain);

    /**
     * Get Domain by domain name
     * @param str $domain
     * @return Domain Domain, null if domain doesn't exist
     */
    public function getDomain($domain);
}

