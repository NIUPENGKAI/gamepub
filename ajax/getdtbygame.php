<?php

if (!defined('SHAISHAI')) {
    exit(1);
}

class GetdtbygameAction extends ShaiAction
{
	function __construct() {
		parent::__construct();
		$this->no_anonymous = false;
	}
	
	function prepare($args) {
		if (! parent::prepare($args)) {return false;}
		$this->gid = $this->trimmed('gid');
		if (empty($this->gid)) {
			$this->clientError('请求缺少参数');
			return false;
		}
		return true;
	}
	
	function handle($args) {
		parent::handle($args);
		
		$jsonstringer = common_stream('games:dts:' . $this->gid, array($this, "_getJsonStringer"), null, 24 * 3600);

		$jsonstringer->flush();
	}
	
	function _getJsonStringer() {
		$jsonstringer = new JsonStringer();
        $jsonstringer->init_document($this->paras);
        $jsonstringer->show_json_objects(Deal_tag::getDealTagsByGameid($this->gid));
        $jsonstringer->end_document();
        return $jsonstringer;
	}
	
}

?>