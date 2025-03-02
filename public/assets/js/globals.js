const BASE_URL = `${window.location.protocol}//${window.location.host}`;
const SEGMENT_URL = `${BASE_URL}${window.location.pathname}`;

let CURRENT_PARAMS = {
    page: 1,
    limit: 10,
    order: 'desc',
    search: ''
};

let searchTimeout;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

function errorAPI(api) {
    const response = api.responseJSON;
    let errorMessage = "Server Internal Error";

    if (response && response.message) {
        if (typeof response.message === "string") {
            errorMessage = response.message;
        }
        else if (typeof response.message === "object") {
            const firstField = Object.keys(response.message)[0];

            if (Array.isArray(response.message[firstField])) {
                errorMessage = response.message[firstField][0];
            }
            else {
                errorMessage = response.message[firstField];
            }
        }
    }

    Swal.fire({
        icon: api.success === true ? "" : "error",
        title: "Oops...",
        text: errorMessage || "Server Internal Error",
    });
}

function handleSearchInput() {
    clearTimeout(searchTimeout);
    
    searchTimeout = setTimeout(() => {
        const searchTerm = $('#search-input').val().trim();
        CURRENT_PARAMS = {
            ...CURRENT_PARAMS,
            page: 1, 
            search: searchTerm
        };
        __loadData(CURRENT_PARAMS);
    }, 800); 
}

function getQueryParams() {
    const params = new URLSearchParams(window.location.search);
    return {
        page: params.get('page') || 1,
        limit: params.get('limit') || 10,
        order: params.get('order') || 'desc',
        search: params.get('search') || ''
    };
}

function updateUrlParams(params) {
    const url = new URL(window.location);
    url.searchParams.set('page', params.page);
    url.searchParams.set('limit', params.limit);
    url.searchParams.set('order', params.order);
    window.history.pushState({}, '', url);
}


function updatePagination(pagination) {
    const paginationNav = $('#pagination-nav');
    const pageNumbers = $('#page-numbers');
    const prevPage = $('#prev-page');
    const nextPage = $('#next-page');
    const firstPage = $('#first-page');
    const lastPage = $('#last-page');

    pageNumbers.empty();

    prevPage.toggleClass('disabled', pagination.current_page === 1);
    prevPage.off('click').on('click', (e) => { 
        e.preventDefault();
        if (pagination.current_page > 1) {
            const newParams = { ...CURRENT_PARAMS, page: pagination.current_page - 1 };
            __loadData(newParams);
        }
    });

    nextPage.toggleClass('disabled', pagination.current_page === pagination.last_page);
    nextPage.off('click').on('click', (e) => { 
        e.preventDefault();
        if (pagination.current_page < pagination.last_page) {
            const newParams = { ...CURRENT_PARAMS, page: pagination.current_page + 1 };
            __loadData(newParams);
        }
    });

    firstPage.toggleClass('disabled', pagination.current_page === 1);
    firstPage.off('click').on('click', (e) => { 
        e.preventDefault();
        if (pagination.current_page !== 1) {
            const newParams = { ...CURRENT_PARAMS, page: 1 };
            __loadData(newParams);
        }
    });

    lastPage.toggleClass('disabled', pagination.current_page === pagination.last_page);
    lastPage.off('click').on('click', (e) => { 
        e.preventDefault();
        if (pagination.current_page !== pagination.last_page) {
            const newParams = { ...CURRENT_PARAMS, page: pagination.last_page };
            __loadData(newParams);
        }
    });

    const currentPage = pagination.current_page;
    const totalLastPage = pagination.last_page;
    const delta = 2;

    if (currentPage > delta + 1) {
        addPageLink(pageNumbers, 1);
        if (currentPage > delta + 2) {
            pageNumbers.append('<li class="page-item disabled"><span class="page-link">...</span></li>');
        }
    }

    for (let i = Math.max(1, currentPage - delta); i <= Math.min(totalLastPage, currentPage + delta); i++) {
        addPageLink(pageNumbers, i, i === currentPage);
    }

    if (currentPage < totalLastPage - delta) {
        if (currentPage < totalLastPage - delta - 1) {
            pageNumbers.append('<li class="page-item disabled"><span class="page-link">...</span></li>');
        }
        addPageLink(pageNumbers, totalLastPage);
    }

    function addPageLink(container, pageNumber, isActive = false) {
        const li = $(`<li class="page-item ${isActive ? 'active' : ''}"></li>`);
        const a = $(`<a class="page-link" href="#">${pageNumber}</a>`);
        a.on('click', (e) => {
            e.preventDefault();
            const newParams = { ...CURRENT_PARAMS, page: pageNumber };
            __loadData(newParams);
        });
        li.append(a);
        container.append(li);
    }
}

$(document).ready(() => {
    const initialParams = getQueryParams();
    CURRENT_PARAMS = initialParams;

    $('#search-input').on('input', handleSearchInput);

    $('#limit-selector').on('change', (e) => {
        const newParams = { 
            ...CURRENT_PARAMS,
            limit: e.target.value,
            page: 1 
        };
        __loadData(newParams);
    });

    $('#order-selector').on('change', (e) => {
        const newParams = { 
            ...CURRENT_PARAMS,
            order: e.target.value,
            page: 1
        };
        __loadData(newParams);
    });

    prevPage.on('click', (e) => {
        e.preventDefault();
        if (pagination.current_page > 1) {
            const newParams = { ...CURRENT_PARAMS, page: pagination.current_page - 1 };
            __loadData(newParams);
        }
    });
    
    nextPage.on('click', (e) => {
        e.preventDefault();
        if (pagination.current_page < pagination.last_page) {
            const newParams = { ...CURRENT_PARAMS, page: pagination.current_page + 1 };
            __loadData(newParams);
        }
    });
    
    firstPage.on('click', (e) => {
        e.preventDefault();
        if (pagination.current_page !== 1) {
            const newParams = { ...CURRENT_PARAMS, page: 1 };
            __loadData(newParams);
        }
    });
    
    lastPage.on('click', (e) => {
        e.preventDefault();
        if (pagination.current_page !== pagination.last_page) {
            const newParams = { ...CURRENT_PARAMS, page: pagination.last_page };
            __loadData(newParams);
        }
    });

    
});