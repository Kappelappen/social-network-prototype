<?php

class PageHandler
{
    private PDO $pdo;

    private int $limit;
    private int $currentPage;


    public function __construct(
        PDO $pdo,
        int $limit = 10)
    {
        $this->pdo = $pdo;
        $this->limit = $limit;
        $this->currentPage = $this->getCurrentPage();
    }

    public function getCurrentPage(): int
{
    return isset($_GET["page"])
        ? max(1,(int)$_GET["page"])
        : 1;
    }

    public function getOffset(): int
    {
        return ($this->currentPage - 1) * $this->limit;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getTotalPages(
        string $table, string $column,
        int $id): int {

        $sql = "
            SELECT COUNT(*)
            FROM $table
            WHERE $column = :id
        ";


        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "id" => $id
        ]);

        $total = (int)$stmt->fetchColumn();


        return max(
            1,
            ceil($total / $this->limit)
        );
    }

    public function render(
        int $profileId,int $totalPages): string {

        $html = '<div class="pagination">';

        if ($this->currentPage > 1) {

            $html .= '
            <a href="profile.php?id='.$profileId.'&page='.
            ($this->currentPage - 1).'">
            Previous
            </a>';
        }



        for ($i = 1; $i <= $totalPages; $i++) {


            if ($i === $this->currentPage) {

                $html .= "<strong>$i</strong>";

            } else {

                $html .= '
                <a href="profile.php?id='.$profileId.'&page='.$i.'">
                '.$i.'
                </a>';

            }
        }



        if ($this->currentPage < $totalPages) {

            $html .= '
            <a href="profile.php?id='.$profileId.'&page='.
            ($this->currentPage + 1).'">
            Next
            </a>';

        }


        $html .= '</div>';

        return $html;
    }
}

?>