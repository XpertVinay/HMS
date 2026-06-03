describe('Admin Registration & Approval Flow', () => {
  const uniqueId = new Date().getTime();
  const subdomain = `org${uniqueId}`;
  const username = `admin${uniqueId}`;
  const email = `admin${uniqueId}@example.com`;

  it('successfully registers a new organization', () => {
    cy.visit('/register.php');

    cy.get('input[name="org_name"]').type(`Sunnyvale RWA ${uniqueId}`);
    cy.get('input[name="org_address"]').type('123 Main Street');
    cy.get('input[name="org_reg_code"]').type(`REG-${uniqueId}`);
    cy.get('input[name="subdomain"]').type(subdomain);

    cy.get('input[name="username"]').type(username);
    cy.get('input[name="email"]').type(email);
    cy.get('input[name="password"]').type('securepassword123');
    cy.get('input[name="confirm_password"]').type('securepassword123');

    cy.get('button[type="submit"]').click();

    cy.get('.glass-alert').should('be.visible').and('contain', 'Registration successful!');
  });

  /*
  it('allows super admin to approve the pending organization', () => {
    // 1. Login as Super Admin
    cy.visit('/login.php');
    cy.get('input[name="username"]').type('superadmin'); // Assuming seeded superadmin
    cy.get('input[name="password"]').type('superadmin123');
    cy.get('button[name="login"]').click();

    // 2. Navigate to approvals
    cy.visit('/super_admin/Dashboard/index.php'); // Assuming this is the dashboard

    // 3. Find the organization and approve it
    cy.contains(`Sunnyvale RWA ${uniqueId}`)
      .parent('tr')
      .find('button') // Assuming an approve button
      .click();

    // Assert approval
    cy.contains('Organization approved');
  });
  */
});
