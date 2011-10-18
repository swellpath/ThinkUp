<?php
/**
 *
 * ThinkUp/tests/TestOfDomainMySQLDAO.php
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
 * Test of Domain MySQL Data Access Object implementation
 *
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2011 SwellPath, Inc.
 * @author Christian G. Warden <cwarden[at]xerus[dot]org>
 *
 */
require_once dirname(__FILE__).'/init.tests.php';
require_once THINKUP_ROOT_PATH.'webapp/_lib/extlib/simpletest/autorun.php';
require_once THINKUP_ROOT_PATH.'webapp/config.inc.php';

class TestOfExternalReferralCountMySQLDAO extends ThinkUpUnitTestCase {
    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        parent::tearDown();
    }

    public function testInsert() {
        $dao = new DomainMySQLDAO();
        $result = $dao->insert('example.com');
        $this->assertEqual($result, 1);
        $this->assertTrue($dao->domainExists('example.com'));
    }

    public function testGetDomain() {
        $dao = new DomainMySQLDAO();
        $domain = $dao->getDomain('example.com');
        $this->assertTrue($domain instanceof Domain);
    }
}
