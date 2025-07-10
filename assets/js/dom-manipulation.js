/**
 * DOM manipulations for the theme.
 */

document.addEventListener("DOMContentLoaded", () => {
	// WooCommerce - Account - Logged out

	const wcAccountLoggedOut = document.querySelector(
		"body.woocommerce-account:not(.logged-in)",
	);

	if (wcAccountLoggedOut) {
		addClassToElements("flow", wcAccountLoggedOut, [
			".col-1.u-column1",
			".col-2.u-column2",
			".woocommerce-form",
			"form.woocommerce-ResetPassword",
		]);
	}

	// WooCommerce - Account - Logged in

	const wcAccountLoggedIn = document.querySelector(
		"body.woocommerce-account.logged-in",
	);

	if (wcAccountLoggedIn) {
		addClassToElements("flow", wcAccountLoggedIn, [
			".woocommerce-MyAccount-content",
			".woocommerce-MyAccount-content > section",
			".woocommerce-address-fields",
			".woocommerce-Address",
			".woocommerce-Address-title",
			".woocommerce-EditAccountForm",
		]);
	}
});

/**
 * Adds a class to elements matching the provided selectors within a container.
 * @param {string} className - The class to add.
 * @param {Element} container - The container element to search within (defaults to document).
 * @param {string[]} selectors - An array of CSS selectors.
 */
function addClassToElements(
	className = "",
	container = document,
	selectors = [],
) {
	selectors.forEach((selector) => {
		const targetElements = container?.querySelectorAll(selector);
		targetElements?.forEach((element) => {
			element?.classList?.add(className);
		});
	});
}

/**
 * Adds a data attribute to elements matching the provided selectors within a container.
 * @param {string} dataAttributeName - The name of the data attribute (e.g., 'direction').
 * @param {string} dataAttributeValue - The value of the data attribute (e.g., 'rtl').
 * @param {Element} container - The container element to search within (defaults to document).
 * @param {string[]} selectors - An array of CSS selectors.
 */
function addDataAttributeToElements(
	dataAttributeName = "",
	dataAttributeValue = "",
	container = document,
	selectors = [],
) {
	selectors.forEach((selector) => {
		const targetElements = container?.querySelectorAll(selector);
		targetElements?.forEach((element) => {
			if (element) {
				element.dataset[dataAttributeName] = dataAttributeValue;
			}
		});
	});
}

/**
 * Adds a role attribute to elements matching the provided selectors within a container.
 * @param {string} roleValue - The value of the role attribute to add.
 * @param {Element} container - The container element to search within (defaults to document).
 * @param {string[]} selectors - An array of CSS selectors.
 */
function addRoleToElements(
	roleValue = "",
	container = document,
	selectors = [],
) {
	selectors.forEach((selector) => {
		const targetElements = container?.querySelectorAll(selector);
		targetElements?.forEach((element) => {
			element?.setAttribute("role", roleValue);
		});
	});
}
