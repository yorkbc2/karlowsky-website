const Gallery = (function () {
	
	/**
	 * @param  {Array<Object>} Array of object with special prop to find unique
	 * @param  {string} Prop name to find
	 * @return {Array<string>} Array of found unique props sorted in DESC order
	 */
	const getUniqueProperties = function (dataSet, prop) {
		const props = [];
		dataSet.forEach(function (item) {
			if (props.indexOf(item[prop]) === -1)
				props.push(item[prop]);
		});	
		return props.sort(function (a, b) {
			return b > a? 1: -1;
		});
	}

	/**
	 * @param  {string} Tag of element to create
	 * @param  {Object} Properties of element (className, ...)
	 * @return {Object} Object with some sugar-syntax methods and root element
	 */
	const $element = function (tagName, options) {
		const element = document.createElement(tagName);

		if (!element)
			console.warn("Sorry, but tagName isn't found!");

		for (var i in options) {
			if (i === 'append') {
				const children = options[i]($element);
				if (typeof children.length !== 'undefined') {
					children.forEach(function (child) {
						element.appendChild(child);
					});
					continue;
				}
				element.appendChild(options[i]($element));
			} else {
				element[i] = options[i];
			}
		}

		return {
			element: element,
			get: function () {
				return this.element;
			},
			append: function (child) {
				this.element.appendChild(child);
				return this;
			},
			appendMany: function (children) {
				const that = this;
				children.forEach(function (child) {
					that.append(child);
				});	
				return this;
			},
			attr: function (attrName, attrValue) {
				if (typeof attrValue === 'undefined')
					return this.element.getAttribute(attrName);
				this.element.setAttribute(attrName, attrValue);
				return this;
			},
			html: function (markup) {
				if (typeof markup === 'undefined')
					return this.element.innerHTML;
				this.element.innerHTML = markup;
				return this;
			},
			val: function (value) {
				if (typeof value === 'undefined')
					return this.element.value;
				this.element.value = value;
				return this;
			}
		};
	}

	/**
	 * @param  {HTMLElement} List of items
	 * @return {Array<Object>} Array with data about items
	 */
	const parseItems = function (listElement) {
		if (!listElement instanceof HTMLElement)
			throw new Error("Sorry, but you must insert '.gallery-items' block in your gallery!");
		const data = [];

		listElement.querySelectorAll("div.gallery-item").forEach(function (item) {
			const dataElement = {};

			for (var i = 0; i < item.children.length; i++) {
				const key = item.children[i].getAttribute('data-key');
				if (key === "image") {
					dataElement[key] = item.children[i].src;
					continue;
				} 
				dataElement[key] = item.children[i].innerHTML;
			}

			data.push(dataElement);
		});

		return data;
	}

	const arePropsEqual = function (objectProps, compareProps) {
		for (var i in compareProps) {
			if (objectProps[i].toString().toLowerCase() !== compareProps[i].toString().toLowerCase()) {
				return false;
			}
		}
		return true;
	}

	return function Gallery (element) {
		if (!element)
			throw new Error("Sorry, but you must pass existed element");

		let yearSelect = null;
		let yearSelectChanger = null;

		const changeSelect = function (select) {
			return function (value) {
				let options = select.get().querySelectorAll("option");
				for (let i = 0; i < options.length; i++) {
					let selected = false;
					if (options[i].value === value) {
						selected = true;
					} 
					options[i].selected = selected;
				}
				return select;
			}
		}

		const data = {
			items: [],
			filteredItems: [],
			currentItem: {}
		};

		const changeYearCallback = function (event, value) {
			yearSelectChanger(value).get().onchange(null, value);
		};

		const contentElements = {
			image: $element("img"),
			meta: $element("p"),
			/**
			 * @param  {string} New image link in content block
			 * @param  {Object} Meta data to update
			 * @return {void}
			 */
			update: function (image, meta) {
				this.image.attr('src', image);
				// this.meta.html(`${meta.name}<br/>${meta.year}, ${meta.place}`);
				this.meta.html("");
				const nameSpan = $element("span", { textContent: meta.name });
				const yearSpan = $element("span", { textContent: meta.year, onclick: function (e) {
					changeYearCallback(e, meta.year);
				}});
				const placeSpan = $element("span", { textContent: ", " + meta.place });
				this.meta.appendMany([
					nameSpan.get(),
					$element("br").get(),
					yearSpan.get(),
					placeSpan.get()
				]);
			}
		};

		const asideElements = {
			filters: $element("div", { className: "gallery-aside-filters" }),
			items: $element("div", { className: "gallery-aside-items" }),
			/**
			 * @param  {Array<Object>} Array of objects to rerender
			 * @return {void}
			 */
			update: function (items) {
				const that = this;
				this.items.html("")
				items.forEach(function (item) {
					that.items.append($element("div", {
						className: "gallery-aside-item",
						append: function (c) {
							return c("img", {
								src: item.image
							}).get();
						},
						onclick: function () {
							contentElements.update(item.image, {...item});
						}
					}).get());
				});
			}
		};

		const asideController = $element("div", {
			className: "gallery-aside",
			append: function (c) {
				return [
					asideElements.filters.get(),
					asideElements.items.get()
				];
			}
		});

		const contentController = $element('div', {
			className: "gallery-content",
			append: function (c) {
				return [
					contentElements.image.get(),
					contentElements.meta.get()
				];
			}
		});

		const activeFilters = {};

		this.rootElement = element;

		data.items = data.filteredItems = parseItems(this.rootElement.querySelector('.gallery-items'));

		this.rootElement.innerHTML = "";

		this.rootElement.classList.add("gallery-loading");

		asideElements.update(data.items);

		yearSelect = $element("select", {
			append: function (c) {
				const optionsData = getUniqueProperties(data.items, 'year');
				optionsData.unshift("Any");
				let options = [];
				if (optionsData.length > 0) {
					return optionsData.map(function (option) {
						return c("option", {
							value: option.toLowerCase(),
							textContent: option
						}).get();
					});
				}
			},
			onchange: function (e, propsValue) {
				let value = propsValue || "";
				if (e && e.target) {
					value = e.target.value
				}

				if (value === "any") {
					delete activeFilters.year;
				} else {
					activeFilters.year = value;
				}

				data.filteredItems = data.items.filter(function (item) {
					return arePropsEqual(item, activeFilters);
				});

				asideElements.update(data.filteredItems);
			}
		});

		yearSelectChanger = changeSelect(yearSelect);

		asideElements.filters.append(yearSelect.get());

		asideElements.filters.append(
			$element("select", {
				append: function (c) {
					const optionsData = getUniqueProperties(data.items, 'place');
					optionsData.unshift("Any");
					let options = [];
					if (optionsData.length > 0) {
						return optionsData.map(function (option) {
							return c("option", {
								value: option.toLowerCase(),
								textContent: option
							}).get();
						});
					}
				},
				onchange: function (e) {
					const value = e.target.value;
					if (value === "any") {
						delete activeFilters.place;
					} else {
						activeFilters.place = value;
					}
					data.filteredItems = data.items.filter(function (item) {
						return arePropsEqual(item, activeFilters);
					});

					asideElements.update(data.filteredItems);
				}
			}).get()
		);

		this.rootElement.appendChild(asideController.get());
		this.rootElement.appendChild(contentController.get());

		this.rootElement.classList.remove('gallery-loading');
		this.rootElement.classList.add('gallery-ready');
		contentElements.update(data.filteredItems[0].image, { ...data.filteredItems[0] });

		const changeSlide = function (dir) {
			dir = dir || 1;
			let index = data.filteredItems.indexOf(data.currentItem);

			if (index === -1) {
				data.currentItem = data.filteredItems[0];
				return 1;
			}
			const next = data.filteredItems[index + dir];

			if (typeof next !== 'undefined') {
				data.currentItem = next;
			} else {
				if (dir > 0) {
					data.currentItem = data.filteredItems[0];
				} else {
					data.currentItem = data.filteredItems[data.filteredItems.length - 1];
				}
			}
			contentElements.update(data.currentItem.image, {...data.currentItem});
		}

		const nextSlide = function () {
			return changeSlide(1);
		}

		const prevSlide = function () {
			return changeSlide(-1);
		}

		const leftArrow = $element("button", {
			className: "gallery-arrow gallery-arrow-left",
			onclick: prevSlide
		});

		const rightArrow = $element("button", {
			className: "gallery-arrow gallery-arrow-right",
			onclick: nextSlide
		});

		const arrowContainer = $element("div", {
			className: "gallery-arrow-container",
			append: function (c) {
				return [
					leftArrow.get(),
					rightArrow.get()
				];
			}
		});

		this.rootElement.appendChild(arrowContainer.get());

		this.getItems = function () {
			return data.items;
		}

		this.getFilteredItems = function () {
			return data.filteredItems;
		}
	}

}())