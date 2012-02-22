<?php
/**
 *
 * ThinkUp/webapp/_lib/model/inteface.ActiveUsersCountDAO.php
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
 * Active Users Count Data Access Object interface
 *
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2011 SwellPath, Inc.
 * @author Christian G. Warden <cwarden[at]xerus[dot]org>
 *
 */
interface ActiveUsersCountDAO  {

    /**
     * Insert or update a count
     * @param int $instance_id
     * @param str $date
     * @param str $period
     * @param int $count
     * @return int Total inserted/updated
     */
    public function upsert($instance_id, $date, $period, $count);

    /**
     * Get timestamp of earliest active user count recorded in database
     * @param int $instance_id
     * @return int unix timestamp
     */
    public function getEarliest($instance_id);

    /**
     * Get timestamp of latest active user count recorded in database
     * @param int $instance_id
     * @return int unix timestamp
     */
    public function getLatest($instance_id);
}
