<?php
/**
 *
 * ThinkUp/tests/TestOfActiveUsersCountMySQLDAO.php
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
 * Test of ActiveUsersCount MySQL DAO implementation
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2011 SwellPath, Inc.
 * @author Christian G. Warden <cwarden[at]xerus[dot]org>
 *
 */
require_once dirname(__FILE__).'/init.tests.php';
require_once THINKUP_ROOT_PATH.'webapp/_lib/extlib/simpletest/autorun.php';

class TestOfActiveUsersCountMySQLDAO extends ThinkUpUnitTestCase {
    public function setUp() {
        parent::setUp();
        $this->builders = self::buildData();
    }

    public function tearDown() {
        $this->builders = null;
        parent::tearDown();
    }

    protected function buildData() {
        $builders = array();
        $builders[] = FixtureBuilder::build('instances', array('id' => 1, 'network_user_id'=>13,
        'network_username'=>'ev', 'is_public'=>1, 'network'=>'facebook page'));

        return $builders;
    }

    public function testUpsertInsert() {
        $instance_id = 1;
        $period = 'month';
        $date = date('Y-m-d');

        $dao = new ActiveUsersCountMySQLDAO();
        $result = $dao->upsert($instance_id, $date, $period, 1);
        $this->assertEqual($result, 1);

        $earliest = $dao->getEarliest($instance_id = 1);
        $this->assertEqual($earliest, strtotime($date));

        $latest = $dao->getLatest($instance_id = 1);
        $this->assertEqual($latest, strtotime($date));
    }

    public function testUpsertUpdate() {
        $dao = new ActiveUsersCountMySQLDAO();
        $instance_id = 1;
        $period = 'month';
        $domain_id = 1;
        $date = date('Y-m-d');
        $builder = FixtureBuilder::build('active_users', array('instance_id' => $instance_id, 'date' => $date,
        'period' => $period, 'count' => 1));
        $result = $dao->upsert($instance_id, $date, $period, 5);
        $this->assertEqual($result, 2);

        $stmt = ActiveUsersCountMySQLDAO::$PDO->query('SELECT COUNT(*) AS count FROM ' . $this->table_prefix .
        'active_users');
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertEqual($data['count'], 1);

        $stmt = ActiveUsersCountMySQLDAO::$PDO->query('SELECT count FROM ' . $this->table_prefix . 'active_users');
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertEqual($data['count'], 5);

    }
}
