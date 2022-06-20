import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  container;
  serial = 0;
  connect() {
    this.container = this.element.querySelector("[data-collection-id]");
  }

  getTemplate() {
    const template = this.element.querySelector("template");
    if (template) {
      const clone = document.importNode(template.content, true);
      this.container.appendChild(clone);
    }
    this.serial++;
  }
}
