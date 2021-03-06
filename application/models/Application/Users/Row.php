<?php
/**
 * Copyright (c) 2012 by Bluz PHP Team
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * @namespace
 */
namespace Application\Users;

use Application\Roles;
use Application\Privileges;

/**
 * User
 *
 * @category Application
 * @package  Users
 *
 * @author   Anton Shevchuk
 * @created  08.07.11 17:13
 */
class Row extends \Bluz\Auth\AbstractEntity
{

    /**
     * Pending email verification
     */
    const STATUS_PENDING = 'pending';
    /**
     * Active user
     */
    const STATUS_ACTIVE = 'active';
    /**
     * Disabled by administrator
     */
    const STATUS_DISABLED = 'disabled';
    /**
     * Removed account
     */
    const STATUS_DELETED = 'deleted';

    // system user with ID=0
    const SYSTEM_USER = 0;

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $created;

    /**
     * @var string
     */
    public $updated;

    /**
     * @var string
     */
    public $status;

    /**
     * __insert
     *
     * @return void
     */
    public function preInsert()
    {
        $this->created = gmdate('Y-m-d H:i:s');
    }

    /**
     * __update
     *
     * @return void
     */
    public function preUpdate()
    {
        $this->updated = gmdate('Y-m-d H:i:s');
    }

    /**
     * Can entity login
     *
     *
     * @throws \Application\Exception
     * @throws \Bluz\Auth\AuthException
     * @return boolean
     */
    public function tryLogin()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                throw new \Bluz\Auth\AuthException("Your account is pending activation");
                break;
            case self::STATUS_DISABLED:
                throw new \Bluz\Auth\AuthException("Your account is disabled by administrator");
                break;
            case self::STATUS_ACTIVE:
                // all ok
                break;
            default:
                throw new \Application\Exception("User status '".$this->status."' is undefined in system");
                break;
        }
    }

    /**
     * Get roles
     */
    public function getRoles()
    {
        return Roles\Table::getInstance()->getUserRoles($this->id);
    }

    /**
     * Get privileges
     */
    public function getPrivileges()
    {
        return Privileges\Table::getInstance()->getUserPrivileges($this->id);
    }

    /**
     * hasRole
     *
     * @param $roleId
     * @return boolean
     */
    public function hasRole($roleId)
    {
        $roles = $this->getRoles();

        foreach ($roles as $role) {
            if (is_numeric($roleId)) {
                if ($role->id == $roleId) {
                    return true;
                }
            } else {
                if ($role->name == $roleId) {
                    return true;
                }
            }
        }

        return false;
    }
}
