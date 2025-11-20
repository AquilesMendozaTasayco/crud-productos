export let products = [];
export let filteredProducts = [];
export let currentPage = 1;
export const pageSize = 5;

export function setProducts(list) {
  products = list || [];
}

export function setFiltered(list) {
  filteredProducts = list || [];
}

export function resetPage() {
  currentPage = 1;
}

export function nextPage(max) {
  if (currentPage < max) currentPage++;
}

export function prevPage() {
  if (currentPage > 1) currentPage--;
}
