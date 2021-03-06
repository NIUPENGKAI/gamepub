<?php
/*
 * LShai - a distributed microblogging tool
 */

if (!defined('SHAISHAI')) { exit(1); }

require_once INSTALLDIR.'/classes/Memcached_DataObject.php';

/**
 * Table Definition for file_to_post
 */

class File_to_post extends Memcached_DataObject
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'file_to_post';                    // table name
    public $file_id;                         // int(4)  primary_key not_null
    public $post_id;                         // int(4)  primary_key not_null
    public $modified;                        // timestamp()   not_null default_CURRENT_TIMESTAMP

    /* Static get */
    function staticGet($k,$v=NULL) { return Memcached_DataObject::staticGet('File_to_post',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    function processNew($file_id, $notice_id) {
        static $seen = array();
        if (empty($seen[$notice_id]) || !in_array($file_id, $seen[$notice_id])) {

            $f2p = File_to_post::pkeyGet(array('post_id' => $notice_id,
                                               'file_id' => $file_id));
            if (empty($f2p)) {
                $f2p = new File_to_post;
                $f2p->file_id = $file_id;
                $f2p->post_id = $notice_id;
                $f2p->insert();
            }

            if (empty($seen[$notice_id])) {
                $seen[$notice_id] = array($file_id);
            } else {
                $seen[$notice_id][] = $file_id;
            }
        }
    }

    function &pkeyGet($kv)
    {
        return Memcached_DataObject::pkeyGet('File_to_post', $kv);
    }
}

