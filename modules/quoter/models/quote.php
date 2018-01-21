<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/quoter/models/quote.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: quote.php 307 2010-01-15 23:28:58Z wiistriker $
 */

/**
 * quote: класс для работы c данными
 *
 * @package modules
 * @subpackage quoter
 * @version 0.3
 */
class quote extends entity
{
    const VOTE_TIMEOUT = 7200;
    const MAX_DESC_CHARS = 2000;
    const CACHE_PREFIX = 'quote_';
    const SESSION_VOTE_TOKEN_PREFIX = 'votetoken_';

    protected $linesCount = 0;
    protected $vote_token = null;

    protected $category = null;

    public function getText($linesNum = null)
    {
        $text = parent::__call('getText', array());
        if ($linesNum > 0 && $linesNum < $this->getLinesCount()) {
            $lines = explode("\n", $text);

            $text = implode("\n", array_slice($lines, 0, $linesNum));

            $lastString = array_pop($lines);
            $text .= "…\n" . $lastString;
        }

        return $text;
    }

    public function getLinesCount()
    {
        if ($this->linesCount == 0) {
            $text = $this->getText();
            $lines = substr_count($text, "\n");
            $this->linesCount = $lines < 1 ? 1 : $lines + 1;
        }

        return $this->linesCount;
    }

    public function generateLines($num = null)
    {
        $lines = array();
        $linesCount = $this->getLinesCount();

        $chars = strlen($linesCount);

        if (!is_null($num) && $num < $linesCount) {
            $linesCount = $num;
        }

        for ($i = 1; $i <= $linesCount; $i++) {
            $lines[] = sprintf('%0' . $chars . 'd', $i);
        }

        return $lines;
    }

    public function setDescription($description)
    {
        $description = mzz_substr($description, 0, self::MAX_DESC_CHARS);
        parent::__call('setDescription', array($description));
    }

    public function getVoteToken()
    {
        if (is_null($this->vote_token)) {
            $session = systemToolkit::getInstance()->getSession();
            $token = md5(microtime(true) . $this->getId());
            $session->set($this->getTokenName(), $token);
            $this->vote_token = $token;
        }

        return $this->vote_token;
    }

    public function getTokenName()
    {
        return self::SESSION_VOTE_TOKEN_PREFIX . $this->getId();
    }

    public function getCacheKey($localPrefix = '')
    {
        return self::CACHE_PREFIX . $localPrefix . $this->getId();
    }

    public function getNewCommentsCount()
    {
        return $this->getCommentsCount() - (int)$this->getSeenCommentsCount();
    }

    public function isSpecial()
    {
		$special_ids = array(
			2222,
			3028,
			3333,
			5555,
			5702,
			6666,
			6700,
			7654,
			7777,
            8451,
			11225
		);

		return in_array((int)$this->getId(), $special_ids);
        //return $this->getId() == 2222 || $this->getId() == 3028 || $this->getId() == 3333 || $this->getId() == 5555 || $this->getId() == 5702;
    }

    public function getCategoryId()
    {
        if ($this->state() == entity::STATE_NEW) {
            return null;
        }

        return $this->data['category_id'];
    }

    public function getCategory()
    {
        if (is_null($this->category)) {
            $cache_key = 'category_' . $this->getCategoryId();
            $cache = cache::factory('memcache');

            $result = $cache->get($cache_key, $category);
            if (!$result) {
                $category = parent::__call('getCategory', array());
                if ($category) {
                    $cache->set($cache_key, $category, array(), 86400);
                }
            }

            $this->category = $category;
        }

        return $this->category;
    }
}
?>