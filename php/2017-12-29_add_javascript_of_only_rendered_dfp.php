<?php
/*
出力したDFP(広告)タグの分だけ、Javascriptを出力する。
*/

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function main()
{
    $dfp = new Dfp;

    // Viewの中
    echo $dfp->renderAd(Dfp::PC_TITLE_BOTTOM_ID);
    echo $dfp->sidebarMiddle(Dfp::PC_COMMENT_TOP_ID);

    // レスポンスを返す前にheadタグ内に挿入
    // 使用した広告分のみを出力
    echo $dfp->mainScript();
}

/**
 * DFP広告のViewクラス
 * 広告IDは定数で管理
 */
final class Dfp
{
    public const PC_TITLE_BOTTOM_ID = 'ad-1234-0';
    public const PC_COMMENT_TOP_ID = 'ad-5689-0';

    /** @var array 広告IDごとの設定値 */
    private $tagData = [
        self::PC_TITLE_BOTTOM_ID => ['/4649/pc_title_bottom', '[600, 100]'],
        self::PC_COMMENT_TOP_ID => ['/4649/pc_comment_top', '[[300, 200], [300, 250]]'],
    ];

    /** @var array 出力された広告のID */
    private $usedAdIds = [];

    private function __construct()
    {
        // singleton
    }

    public static function getInstance(): self
    {
        static $instance = null;
        if (is_null($instance)) {
            $instance = new self;
        }
        return $instance;
    }

    /**
     * 広告を動作させるメインスクリプト
     * @return string
     */
    public function renderMainScript(): string
    {
        ob_start(); ?>
        <script async='async'
                src='https://www.googletagservices.com/tag/js/gpt.js'></script>
        <script>
          var googletag = googletag || {};
          googletag.cmd = googletag.cmd || [];
          googletag.cmd.push(function () {
            <? foreach ($this->usedAdIds as $id) : ?>
              googletag
                .defineSlot('<?= $this->tagData[$id][0] ?>', <?= $this->tagData[$id][1] ?>, '<?= $id ?>')
                .addService(googletag.pubads());
             <? endforeach; ?>
            googletag.pubads().enableSingleRequest();
            googletag.enableServices();
          });
        </script>
        <?
        return ob_get_clean();
    }

    /**
     * 広告を出力する
     * @param string $adId クラス定数で指定
     * @return string
     */
    public function renderAd(string $adId): string
    {
        $this->addUsedAdId($adId);
        ob_start(); ?>
        <div id='<?= $adId ?>'>
            <script>
              googletag.cmd.push(function () {
                googletag.display('<?= $adId ?>');
              });
            </script>
        </div>
        <?
        return ob_get_clean();
    }

    /**
     * 出力した広告のIDを記録する。
     * 重複するIDは追加されない。自動でユニークになる。
     * @param string $adId
     */
    private function addUsedAdId(string $adId): void
    {
        if (array_key_exists($adId, $this->usedAdIds)) {
            return;
        }
        $this->usedAdIds[] = $adId;
    }
}

main();
