<div class="col-md-4 mb-4">
    <div class="card h-100">
        <% if $Image %>
            <a href="$Link" class="text-decoration-none">
                <img src="$Image.URL" class="card-img-top" alt="$Image.Title">
            </a>
        <% end_if %>
        <div class="card-body">
            <% if $PrimaryCategory %>
                <p class="text-uppercase text-muted small mb-1">$PrimaryCategory.Title</p>
            <% end_if %>
            <h5 class="card-title">
                <a href="$Link" class="text-decoration-none">$Title</a>
            </h5>
            <div class="d-flex justify-content-between text-muted small">
                <% if $PrepTime %>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-alarm me-1"></i> Prep: $PrepTime
                    </div>
                <% end_if %>
                <% if $CookTime %>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clock me-1"></i> Cook: $CookTime
                    </div>
                <% end_if %>
                <% if $Servings %>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-people me-1"></i> Servings: $Servings
                    </div>
                <% end_if %>
            </div>
            <% if $Summary %>
                <p class="card-text mt-2">$Summary.LimitCharacters(100)</p>
            <% end_if %>
        </div>
        <div class="card-footer">
            <a href="$Link" class="btn btn-primary btn-block">View Recipe</a>
        </div>
    </div>
</div>