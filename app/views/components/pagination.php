<!-- app/views/components/pagination.php -->
<?php if ($pagination['pages'] > 1): ?>
  <nav aria-label="Pagination des trajets">
    <ul class="pagination justify-content-center">
      <!-- Lien Précédent -->
      <li class="page-item <?= $pagination['currentPage'] <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="?page=<?= $pagination['currentPage'] - 1 ?>
                    <?= !empty($currentFilters['depart']) ? '&depart=' . $currentFilters['depart'] : '' ?>
                    <?= !empty($currentFilters['arrivee']) ? '&arrivee=' . $currentFilters['arrivee'] : '' ?>">
          <i class="bi bi-chevron-left"></i> Précédent
        </a>
      </li>

      <!-- Liens des pages -->
      <?php for ($i = 1; $i <= $pagination['pages']; $i++): ?>
        <li class="page-item <?= $i === $pagination['currentPage'] ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>
                        <?= !empty($currentFilters['depart']) ? '&depart=' . $currentFilters['depart'] : '' ?>
                        <?= !empty($currentFilters['arrivee']) ? '&arrivee=' . $currentFilters['arrivee'] : '' ?>">
            <?= $i ?>
          </a>
        </li>
      <?php endfor; ?>

      <!-- Lien Suivant -->
      <li class="page-item <?= $pagination['currentPage'] >= $pagination['pages'] ? 'disabled' : '' ?>">
        <a class="page-link" href="?page=<?= $pagination['currentPage'] + 1 ?>
                    <?= !empty($currentFilters['depart']) ? '&depart=' . $currentFilters['depart'] : '' ?>
                    <?= !empty($currentFilters['arrivee']) ? '&arrivee=' . $currentFilters['arrivee'] : '' ?>">
          Suivant <i class="bi bi-chevron-right"></i>
        </a>
      </li>
    </ul>
  </nav>
<?php endif; ?>