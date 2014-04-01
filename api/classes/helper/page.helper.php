<?php
/**
 * @author: Jonathan Hollingsworth
 * @description: Page Helper Class
 */


require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/classes/page.class.php";
require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/classes/content.class.php";


class PageHelper {

    /**
     * @var mysqli $con
     */
    private $con;

    function __construct()
    {
        $this->con = getConnection();
    }

    public function getPages()
    {
        $title = '';
        $reference = '';
        $heroText = '';
        $contentId = 0;
        $html = '';

        $sql = 'select p.pageId, p.title, p.reference, p.heroText, c.contentId, c.html from pages p left join content c on p.pageId = c.pageId where '.
                'p.status=1 and (c.status=1 or c.status is null)';
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pageId, $title, $reference, $heroText, $contentId, $html);

        $pages = array();

        if ($stmt->num_rows > 0) {
            while ($stmt->fetch())
            {
                $page = new Page();
                $page->pageId = $pageId;
                $page->title = $title;
                $page->reference = $reference;
                $page->heroText = $heroText;

                $content = new Content();
                $content->html = $html;
                $page->content = $content;

                $pages[] = $page;
            }
        }

        return $pages;

    }

    public function getPage($pageId)
    {
        $title = '';
        $reference = '';
        $contentId = 0;
        $html = '';
        $heroText = '';

        $sql = 'select p.pageId, p.title, p.reference, p.heroText, c.contentId, c.html from pages p left join content c on p.pageId = c.pageId where '.
            'p.status=1 and (c.status=1 or c.status is null) and p.pageId=?';
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $pageId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pageId, $title, $reference, $heroText, $contentId, $html);

        $page = new Page();

        if ($stmt->num_rows > 0) {
            while ($stmt->fetch())
            {
                $page->pageId = $pageId;
                $page->title = $title;
                $page->reference = $reference;
                $page->heroText = $heroText;

                $content = new Content();
                $content->html = $html;
                $page->content = $content;
            }
        }

        return $page;
    }


    public function savePage($page)
    {
        if (isset($page->pageId)) {
            // Update the page row
            $sql = 'update pages set title=?, reference=?, heroText=? where pageId=?';
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('sssi', $page->title, $page->reference, $page->heroText, $page->pageId);
            $stmt->execute();

            // set any existing content rows to archived
            $sql = 'update content set status=2 where pageId=?';
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('i', $page->pageId);
            $stmt->execute();

            //Insert a new row for the html if any has been set
            if (isset($page->html)) {
                $sql = 'insert into content (pageId, html, created) values (?, ?, now())';
                $stmt = $this->con->prepare($sql);
                $stmt->bind_param('is', $page->pageId, $page->html);
                $stmt->execute();
            }

        } else {
            // New
            $sql = 'insert into pages (title, reference, heroText, created) values (?, ?, now())';
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('sss', $page->title, $page->reference, $page->heroText);
            $stmt->execute();
            $stmt->store_result();

            $pageId = $stmt->insert_id;

            $sql = 'insert into content (pageId, html, created) values ($pageId, ?, now())';
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('s', $page->html);
            $stmt->execute();
        }

        return array('success'=>true);
    }

    public function getPageByRef($ref)
    {
        $pageId = 0;
        $title = '';
        $html = '';
        $heroText = '';

        $sql = "select pageId, title, heroText from pages where reference = ? limit 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('s', $ref);
        $stmt->execute();
        $stmt->bind_result($pageId, $title, $heroText);

        $page = new Page();
        while ($stmt->fetch()) {
            $page->pageId = $pageId;
            $page->title = $title;
            $page->heroText = $heroText;
        }

        $content = new Content();
        $sql = "select html from content where pageId=$pageId";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($html);

        while ($stmt->fetch()) {
            $content->html = $html;
        }

        $page->content = $content;

        return $page;

    }
}