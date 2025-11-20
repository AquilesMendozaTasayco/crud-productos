import { getAllProducts } from "./api.js";
import {
  products,
  filteredProducts,
  currentPage,
  pageSize,
  setProducts,
  setFiltered,
  resetPage,
  nextPage,
  prevPage,
} from "./state.js";

import {
  showSkeleton,
  renderTable,
  updatePagination,
  openModal,
  closeModal,
} from "./ui.js";

import { handleEdit, handleDelete, handleSubmit } from "./handlers.js";

const tbody = document.getElementById("products-body");
const emptyState = document.getElementById("empty-state");

const search = document.getElementById("search");
const totalProductsEl = document.getElementById("total-products");
const totalValueEl = document.getElementById("total-value");

const pagination = document.getElementById("pagination");
const prevBtn = document.getElementById("prev-page");
const nextBtn = document.getElementById("next-page");
const currentPageEl = document.getElementById("current-page");
const lastPageEl = document.getElementById("last-page");

const modal = document.getElementById("modal");
const content = document.getElementById("modal-content");
const form = document.getElementById("modal-form");
const modalTitle = document.getElementById("modal-title");

const idField = document.getElementById("product_id");
const nameField = document.getElementById("name");
const priceField = document.getElementById("price");
const descField = document.getElementById("description");

const formFields = { id: idField, name: nameField, price: priceField, desc: descField };
const modalRefs = { modal, content, form, title: modalTitle };

async function loadProducts() {
  showSkeleton(tbody, emptyState);

  const json = await getAllProducts();
  if (json.status === 200) setProducts(json.data);
  else setProducts([]);

  applyFilters();
}

function applyFilters() {
  const term = search.value.toLowerCase().trim();

  setFiltered(
    products.filter((p) =>
      !term ||
      p.name.toLowerCase().includes(term) ||
      (p.description || "").toLowerCase().includes(term)
    )
  );

  const total = filteredProducts.length;
  const totalValue = filteredProducts.reduce((a, b) => a + parseFloat(b.price), 0);

  totalProductsEl.textContent = total;
  totalValueEl.textContent = totalValue.toFixed(2);

  const lastPage = updatePagination(total, pagination, currentPageEl, lastPageEl, prevBtn, nextBtn);

  const start = (currentPage - 1) * pageSize;
  const pageItems = filteredProducts.slice(start, start + pageSize);

  renderTable(pageItems, tbody, emptyState);
}

search.addEventListener("input", () => {
  resetPage();
  applyFilters();
});

prevBtn.addEventListener("click", () => {
  prevPage();
  applyFilters();
});

nextBtn.addEventListener("click", () => {
  nextPage(Math.ceil(filteredProducts.length / pageSize));
  applyFilters();
});

tbody.addEventListener("click", (e) => {
  const btn = e.target.closest("button");
  if (!btn) return;

  const id = btn.dataset.id;

  if (btn.classList.contains("edit-btn")) {
    handleEdit(id, formFields, modalRefs);
  } else if (btn.classList.contains("delete-btn")) {
    handleDelete(id, loadProducts);
  }
});

form.addEventListener("submit", (e) =>
  handleSubmit(e, formFields, loadProducts, modalRefs)
);

document.getElementById("open-modal").addEventListener("click", () => {
  modalTitle.textContent = "Nuevo Producto";
  openModal(modal, content);
});

document.getElementById("close-modal").addEventListener("click", () =>
  closeModal(modal, content, form, idField, modalTitle)
);

document.getElementById("close-modal-btn").addEventListener("click", () =>
  closeModal(modal, content, form, idField, modalTitle)
);

modal.addEventListener("click", (e) => {
  if (e.target === modal)
    closeModal(modal, content, form, idField, modalTitle);
});

loadProducts();
