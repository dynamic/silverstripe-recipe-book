<div class="container mt-4">
    <div class="row">
    <% loop $paginatedList %>
        <div class="card col-md-4">
            <% if $CategoryImage %>
                <img src="$CategoryImage.URL" class="img-fluid" />
            <% else %>
                <img src="_resources/themes/cheesesociety/images/recipe-default.jpg" class="img-fluid">
            <% end_if %>
            <div class="card-body apply-font">
                <h3 class="text-center recipe-title">$Title</h3>
                <% if $Content %><p class="card-text">$Content</p><% end_if %>
            </div>
            <div class="card-body text-center pt-0">
                <a href="$Link" class="btn recipe-link btn-primary">View All</a>
            </div>
        </div>
    <% end_loop %>
    </div>
</div>

<% if $paginatedList.MoreThanOnePage %>
    <nav aria-label="Recipe Category Navigation">
        <ul class="pagination justify-content-center">
    <% if $paginatedList.NotFirstPage %>
            <li class="page-item disabled">
                <a class="page-link" href="$paginatedList.PrevLink" tabindex="-1">Previous</a>
            </li>
    <% end_if %>
    <% loop $paginatedList.PaginationSummary %>
        <% if $CurrentBool %>
            <li class="page-item active">
                <span class="page-link">$PageNum<span class="sr-only">(current)</span></span>
            </li>
        <% else %>
            <% if $Link %>
            <li class="page-item"><a class="page-link" href="$Link">$PageNum</a></li>
            <% else %>
                ...
            <% end_if %>
        <% end_if %>
    <% end_loop %>
    <% if $paginatedList.NotLastPage %>
            <li class="page-item">
                <a class="page-link" href="$paginatedList.NextLink">Next</a>
            </li>
    <% end_if %>
        </ul>
    </nav>
<% end_if %>