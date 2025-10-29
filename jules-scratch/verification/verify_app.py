from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch()
    page = browser.new_page()

    base_url = "http://localhost:5173/"

    # Navigate to the Home page and take a screenshot
    page.goto(base_url)
    page.wait_for_selector('h1:has-text("Your Next Adventure Awaits")')
    page.screenshot(path="jules-scratch/verification/homepage.png")

    # Navigate to the Catalog page and take a screenshot
    page.goto(f"{base_url}catalog")
    page.wait_for_selector('h1:has-text("Game Catalog")')
    page.screenshot(path="jules-scratch/verification/catalogpage.png")

    # Log in as admin to see the dashboard
    page.goto(f"{base_url}login")
    page.fill('input[type="email"]', 'admin@gamestore.com')
    page.fill('input[type="password"]', 'admin') # Simplified password for mock data
    page.click('button:has-text("Sign in")')

    # Navigate to the Admin Dashboard page and take a screenshot
    page.goto(f"{base_url}admin")
    page.wait_for_selector('h1:has-text("Admin Dashboard")')
    page.screenshot(path="jules-scratch/verification/admindashboard.png")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
