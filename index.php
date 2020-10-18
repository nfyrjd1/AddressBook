    <?php include($_SERVER['DOCUMENT_ROOT'].'/addressbook/core/view/header.php') ?>

        <?php 
            if ($_POST) {
                include($_SERVER['DOCUMENT_ROOT'].'/addressbook/core/controller/contact_controller.php');
            }
            else {
                ?>
                    <section class="search">
                        <h2 class="hidden">Поиск контактов</h2>
                        <form class="search-form" action="index.php" method="GET">
                            <?php 
                                $search = isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : null;
                                $pageNum = isset($_GET['page']) && !empty($_GET['page']) ? (int)$_GET['page'] : 1;

                                echo '<input class="input" type="text" name="search" placeholder="Фамилия, имя, отчество контакта" value="'.$search.'">'
                            ?>
                            <button class="button" type="submit">Найти</button>
                        </form>
                    </section>

                    <section class="contacts">
                        <div class="contacts-title">
                            <h2>Список контактов</h2>
                            <button type="button" class="button show-adding-modal">Добавить</button>
                        </div>

                        <?php
                        include($_SERVER['DOCUMENT_ROOT'].'/addressbook/core/model/db.php');
                        $db = new DB();
                        $contacts = $db->getContacts($pageNum, 10, $search);
                        if (count($contacts) > 0) {
                            echo '<ul class="contacts-list">';
                            include($_SERVER['DOCUMENT_ROOT'].'/addressbook/core/view/contact_view.php');
                            foreach ($contacts as $contact) {
                                ContactView::displayContactItem($contact);
                            }
                            echo '</ul>';
                        } else {
                            echo '<p>Ничего не найдено</p>';
                        }

                        $contactsCount = $db->getContactsCount($search);
                        $pagesCount = ceil($contactsCount / $db->pageSize);
                        if ($pagesCount > 1) {

                            echo '<nav>';
                            echo '<ul class="paginator-list">';

                            $i = $pageNum - 3;
                            $search = isset($search) ? '&search='.$search : null;
                            if ($i >= 2) {
                                echo '<li class="paginator-item">';
                                echo '<a href="index.php?page=1'.$search.'">Начало</a>';
                                echo '</li>';
                            }

                            if ($i <= 0) $i = 1;
                            for ($i; $i <= $pagesCount && $i <= $pageNum+3; $i++) {
                                if ($i == $pageNum) echo '<li class="paginator-item paginator-item-current">';
                                else echo '<li class="paginator-item">';

                                echo '<a href="index.php?page='.$i.$search.'">'.$i.'</a>';
                                echo '</li>';
                            }
                            $i--;
                            if ($pagesCount - $i >= 1) {
                                echo '<li class="paginator-item">';
                                echo '<a href="index.php?page='.$pagesCount.$search.'">Последняя</a>';
                                echo '</li>';
                            }

                            echo '</nav>';
                            echo '</ul>';
                        }
                        ?>

                    </section>
                <?php
            }
        ?>

    <?php include($_SERVER['DOCUMENT_ROOT'].'/addressbook/core/view/footer.php') ?>