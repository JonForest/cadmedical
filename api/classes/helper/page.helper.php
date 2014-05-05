<?php
/**
 * @author: Jonathan Hollingsworth
 * @description: Page Helper Class
 */

if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === 'www.able-futures.com' ||
    $_SERVER['SERVER_NAME'] === 'able-futures.com' ) {
    $path = '/cadmedical';
} else {
    $path = '';
}

require $_SERVER["DOCUMENT_ROOT"]. $path ."/api/classes/page.class.php";
require $_SERVER["DOCUMENT_ROOT"]. $path . "/api/classes/content.class.php";


class PageHelper {

    /**
     * @var mysqli $con
     */
    private $con;

    function __construct()
    {
        $this->con = getConnection();
    }

    public function getPageLinks()
    {
        $title = '';
        $pageId = 0;
        $reference = '';


        $sql = "select p.pageId, p.title, p.reference from pages p where ".
            "p.status not in (0,2)";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pageId, $title, $reference);
        $pages = array();

        if ($stmt->num_rows > 0) {
            while ($stmt->fetch())
            {
                $page = new Page();
                $page->pageId = $pageId;
                $page->title = $title;
                $page->reference = $reference;

                $pages[] = $page;
            }
        }

        return $pages;
    }

    public function getPages()
    {
        $title = '';
        $reference = '';
        $heroText = '';
        $contentId = 0;
        $html = '';

        $sql = "select p.pageId, p.title, p.reference, p.heroText, c.contentId, c.html from pages p left join content c on p.pageId = c.pageId where ".
            "p.status not in (0) and (c.status=1 or c.status is null)";
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
        $status = 0;

        $sql = "select p.pageId, p.title, p.reference, p.heroText, c.contentId, c.html, p.status from pages p left ".
            "join content c on p.pageId = c.pageId where ".
            "(c.status=1 or c.status is null) and p.pageId=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $pageId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($pageId, $title, $reference, $heroText, $contentId, $html, $status);

        $page = new Page();

        if ($stmt->num_rows > 0) {
            while ($stmt->fetch())
            {
                $page->pageId = $pageId;
                $page->title = $title;
                $page->reference = $reference;
                $page->heroText = $heroText;
                $page->status = $status;

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
            $sql = 'update pages set title=?, reference=?, heroText=?, status=? where pageId=?';
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('sssii', $page->title, $page->reference, $page->heroText, $page->status, $page->pageId);
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
            $sql = 'insert into pages (title, reference, heroText, status, created) values (?, ?, ?, now())';
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('sssi', $page->title, $page->reference, $page->heroText, $page->status);
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

    /**
     * Get a page from a provided reference string
     * @param string $ref
     * @return Page
     */
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

    /**
     * Get all the statuses
     */
    public function getStatuses()
    {
        $statuses = array();

        $sql = "select statusId, description from statuses where description not in ('Deleted')";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($statusId, $description);

        $status = array();
        while ($stmt->fetch()) {
            $status['statusId'] = $statusId;
            $status['description'] = $description;

            $statuses[] = $status;
        }

        return $statuses;
    }
}