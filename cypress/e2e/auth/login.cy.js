describe('Authentication Flow', () => {
  beforeEach(() => {
    // Visit the login page before each test
    cy.visit('/login.php')
  })

  it('successfully loads the login page', () => {
    // Assert the logo is visible and the page loaded
    cy.get('img[alt="Businzo Logo"]').should('be.visible')
    cy.contains('Log in to the')
  })

  it('fails login with invalid credentials', () => {
    // Type incorrect credentials
    cy.get('input[name="username"]').type('invalid_user')
    cy.get('input[name="password"]').type('wrong_password')
    
    // Submit the form
    cy.get('button[name="login"]').click()

    // Assert that the error message is displayed
    cy.get('.glass-alert').should('be.visible').and('contain', 'Invalid username or password')
  })

  // Note: To test a successful login, we need seeded database users.
  // Assuming a seeded admin user 'admin'/'admin123' exists in the hms_test DB:
  /*
  it('successfully logs in an admin user', () => {
    cy.get('input[name="username"]').type('admin')
    cy.get('input[name="password"]').type('admin123')
    cy.get('button[name="login"]').click()

    // Assuming successful login redirects to admin dashboard
    cy.url().should('include', '/admin/Dashboard/admin.php')
    
    // Assert the sidebar loaded and shows the right portal type
    cy.get('.dashboard').should('contain', 'Admin Portal')
  })
  */
})
