<?php
include_once 'ContactModel.php';
include_once DB_PATH;

class ContactListModel
{
    private $pageSize = 10;

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function getContacts($filter = null, $pageSize = 10)
    {
        $this->pageSize = $pageSize > 0 ? $pageSize : $this->pageSize;
        if (isset($filter)) {
            $pageNum = $filter->getPage() > 0 ? ($filter->getPage() - 1) * $this->pageSize : 0;;
            $search = $filter->getSearch();
        }

        $db = mysql::getContext();
        $query = 'Select Id_Contact, Name, Phone, Address, Email, Birthday, Image From contact Where Lower(Name) Like Lower(IFNULL(?, Name)) Limit ?,?;';
        if (isset($search)) {
            $search = "%$search%";
        }

        $db->execute($query, ['sii', &$search, &$pageNum, &$pageSize]);
        $contacts = [];
        while ($contact = $db->fetch_result()) {
            array_push($contacts, ContactModel::setContact($contact));
        }
        return $contacts;
    }

    public function getContactsCount($search = null)
    {
        $db = mysql::getContext();
        $query = 'Select Count(Id_Contact) ContactsCount From contact Where Lower(Name) Like Lower(IFNULL(?, Name));';
        if (isset($search)) {
            $search = "%$search%";
        }

        $db->execute($query, ['s', &$search]);
        $count = $db->fetch_result();
        return $count['ContactsCount'];
    }

    public function getPaginator($filter)
    {
        if (isset($filter)) {
            $pageNum = $filter->getPage();
            $search = $filter->getSearch();
        }

        $paginator = [];
        $pagesCount = ceil($this->getContactsCount($search) / $this->getPageSize());
        if ($pagesCount > 1) {
            $i = 1;
            $i = $pageNum - 2;

            if ($i >= 2) array_push($paginator, array('index.php?view=list&page=1'.(empty($search) ? '' : '&search=' . $search), 'Начало', $pageNum == 1));

            if ($i <= 0) $i = 1;

            for ($i; $i < $pagesCount && $i <= $pageNum + 3; $i++) {
                $isCurrent = false;
                if ($i == $pageNum) $isCurrent = true;
                array_push($paginator, array('index.php?view=list&page=' . $i . (empty($search) ? '' : '&search=' . $search), $i, $isCurrent));
            }

            if ($pageNum <= $pagesCount)
                array_push($paginator, array('index.php?view=list&page='.$pagesCount.(empty($search) ? '' : '&search=' . $search), 'Последняя', $pageNum == $pagesCount));
        }

        return $paginator;
    }
}
