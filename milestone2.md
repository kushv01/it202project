<table><tr><td> <em>Assignment: </em> IT202 Milestone 2 Bank Project</td></tr>
<tr><td> <em>Student: </em> Kushagra Verma (kv378)</td></tr>
<tr><td> <em>Generated: </em> 12/19/2024 7:15:47 PM</td></tr>
<tr><td> <em>Grading Link: </em> <a rel="noreferrer noopener" href="https://learn.ethereallab.app/homework/IT202-AR451-M2024/it202-milestone-2-bank-project/grade/kv378" target="_blank">Grading</a></td></tr></table>
<table><tr><td> <em>Instructions: </em> <ol><li>Checkout Milestone2 branch</li><li>Create a new markdown file called milestone2.md</li><li>git add/commit/push immediate</li><li>Fill in the below deliverables</li><li>At the end copy the markdown and paste it into milestone2.md</li><li>Add/commit/push the changes to Milestone2</li><li>PR Milestone2 to dev and verify</li><li>PR dev to prod and verify</li><li>Checkout dev locally and pull changes to get ready for Milestone 3</li><li>Submit the direct link to this new milestone2.md file from your GitHub prod branch to Canvas</li></ol><p>Note: Ensure all images appear properly on github and everywhere else. Images are only accepted from dev or prod, not local host. All website links must be from prod (you can assume/infer this by getting your dev URL and changing dev to prod).</p></td></tr></table>
<table><tr><td> <em>Deliverable 1: </em> Create Accounts table and setup </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a screenshot from the db of the system user (Users table)</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-19T21.46.37Screenshot%202024-12-19%20at%204.46.31%20PM.png.webp?alt=media&token=c997d987-fe92-4105-81a0-5d771efd0942"/></td></tr>
<tr><td> <em>Caption:</em> <p>The user at the top represents the system user.<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a screenshot from the db of the world account (Accounts table)</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-19T21.47.30Screenshot%202024-12-19%20at%204.47.28%20PM.png.webp?alt=media&token=976e86a7-e614-4b49-8882-6698687dee92"/></td></tr>
<tr><td> <em>Caption:</em> <p>There is only one account at the moment which is the world account.<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Explain the purpose and usage of these two entries and how they relate</td></tr>
<tr><td> <em>Response:</em> <p>The <strong>system user</strong> and <strong>world account</strong> serve foundational roles in maintaining the integrity<br>and operational functionality of the system. The <strong>system user</strong> (with a unique negative<br>ID) acts as a placeholder entity for system-level processes, ensuring no conflicts with<br>regular users. It is not designed for login but exists to facilitate internal<br>operations. The <strong>world account</strong>, associated with the system user and identified by the<br>account number "000000000000," serves as a central ledger for global transactions, such as<br>initializing balances, system-wide credits or debits, and handling operations not tied to specific<br>users. Together, they provide a robust mechanism for managing system-wide activities while maintaining<br>clear separation from user-specific accounts and transactions.</p><br></td></tr>
<tr><td> <em>Sub-Task 4: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/kushv01/it202project/pull/2">https://github.com/kushv01/it202project/pull/2</a> </td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 2: </em> Dashboard </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a screenshot showing the requested links/navigation</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-19T22.09.58Screenshot%202024-12-19%20at%205.09.51%20PM.png.webp?alt=media&token=a75700c5-7696-4ba2-bc69-7e5d5593a02e"/></td></tr>
<tr><td> <em>Caption:</em> <p>my landing page with dashboard on top <br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-19T22.10.15Screenshot%202024-12-19%20at%205.10.12%20PM.png.webp?alt=media&token=9ec977ef-a336-4cb8-b9b6-2be56843f7db"/></td></tr>
<tr><td> <em>Caption:</em> <p>the dashboard page<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Explain which ones are working for this milestone</td></tr>
<tr><td> <em>Response:</em> <p>all the links would work for this milestone.&nbsp;<br></p><br></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/kushv01/it202project/pull/3">https://github.com/kushv01/it202project/pull/3</a> </td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 3: </em> Create a checking Account </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707834-bf5a5b13-ec36-4597-9741-aa830c195be2.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a screenshot showing the Create Account Page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-19T22.28.04Screenshot%202024-12-19%20at%205.28.01%20PM.png.webp?alt=media&token=1966472e-d2d0-4e87-9371-72e584ab9bf6"/></td></tr>
<tr><td> <em>Caption:</em> <p>create account page<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add screenshots showing validation errors and success message</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-19T22.27.41Screenshot%202024-12-19%20at%205.27.36%20PM.png.webp?alt=media&token=7386918f-008a-4b65-959e-176216d6ea7b"/></td></tr>
<tr><td> <em>Caption:</em> <p>error message<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-19T22.28.24Screenshot%202024-12-19%20at%205.28.19%20PM.png.webp?alt=media&token=f633bdd7-b3c2-4a9c-b1b8-9969cc158676"/></td></tr>
<tr><td> <em>Caption:</em> <p>success message after being transferred to dashboard page<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add a screenshot showing the transaction generated from the initial deposit (from the DB)</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-19T22.29.32Screenshot%202024-12-19%20at%205.29.29%20PM.png.webp?alt=media&token=0efd51a8-3fe7-4a06-9022-4a871f22cd8b"/></td></tr>
<tr><td> <em>Caption:</em> <p>the bottom two are the recent debit and credits<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 4: </em> Explain which account number generation you used and the account creation process including the transaction logic</td></tr>
<tr><td> <em>Response:</em> <p>For the account number generation, <strong>Option 1</strong> was used: "Generate a random 12<br>digit/character value; must regenerate if a duplicate collision occurs." In this approach, the<br>system generates a random 12-digit account number and checks for uniqueness by querying<br>the database to ensure no collision occurs. If a duplicate is found, a<br>new number is generated until a unique value is confirmed.</p><p>The account creation process<br>involves several steps. First, the user selects the account type (either "checking" or<br>"saving") and specifies the deposit amount, which must be a minimum of $5.<br>Upon form submission, the system generates the unique account number and associates it<br>with the logged-in user by inserting a new record into the <code>Accounts</code> table.<br>Simultaneously, a transaction pair is recorded in the Transactions&nbsp;table. This includes a debit<br>from the "world" account (account number <code>000000000000</code>) for the specified deposit amount and<br>a corresponding credit to the newly created account. The balances for both the<br>"world" account and the user's new account are updated dynamically by summing the<br><code>balance_change</code> values from the Transactions&nbsp;table, ensuring data consistency. Once the account is created<br>successfully, the user is redirected to the dashboard with a success message and<br>a masked account number.</p><br></td></tr>
<tr><td> <em>Sub-Task 5: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/kushv01/it202project/pull/4">https://github.com/kushv01/it202project/pull/4</a> </td></tr>
<tr><td> <em>Sub-Task 6: </em> Add a direct link to heroku prod for this file</td></tr>
<tr><td>Not provided</td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 4: </em> User will be able to list their accounts </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707834-bf5a5b13-ec36-4597-9741-aa830c195be2.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a screenshot showing the user's account list view (show 5 accounts)</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-19T22.36.47Screenshot%202024-12-19%20at%205.36.44%20PM.png.webp?alt=media&token=0c46bf75-a9e6-4f19-a986-2d5ed0cd96fc"/></td></tr>
<tr><td> <em>Caption:</em> <p>account page<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Briefly explain how the page is displayed and the data lookup occurs</td></tr>
<tr><td> <em>Response:</em> <p>The <strong>My Accounts</strong> page is displayed by first verifying the user's login status;<br>if not logged in, they are redirected to the login page. Upon successful<br>authentication, the system retrieves the user's account details from the <code inline="">Accounts</code> table,<br>limiting the results to the most recent 5 entries. For each account, the<br><code inline="">account_number</code>, <code inline="">account_type</code>, <code inline="">modified</code> date, and dynamically calculated <code inline="">balance</code> are<br>fetched. The <code inline="">balance</code> is determined by summing all credits (<code inline="">account_dest</code>) and<br>subtracting all debits (<code inline="">account_src</code>) from the <code inline="">Transactions</code> table, ensuring accuracy. The<br>data is then rendered in a responsive table format, with user-friendly styling consistent<br>with the overall UI. If no accounts are found, a prompt to create<br>an account is displayed, linking to the <code inline="">create_account.php</code> page.</p><br></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/kushv01/it202project/pull/5">https://github.com/kushv01/it202project/pull/5</a> </td></tr>
<tr><td> <em>Sub-Task 4: </em> Add a direct link to heroku prod for this file</td></tr>
<tr><td>Not provided</td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 5: </em> Account Transaction Details </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707834-bf5a5b13-ec36-4597-9741-aa830c195be2.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add a screenshot of an account's transaction history</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-19T22.44.42Screenshot%202024-12-19%20at%205.44.40%20PM.png.webp?alt=media&token=7a372552-8056-422b-93c7-cae90d138f52"/></td></tr>
<tr><td> <em>Caption:</em> <p>transaction history<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-19T22.44.57Screenshot%202024-12-19%20at%205.44.50%20PM.png.webp?alt=media&token=d7f3ddde-9d54-4b43-93b4-cec71c2f2c5b"/></td></tr>
<tr><td> <em>Caption:</em> <p>my accounts page<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Explain how the lookup and display occurs</td></tr>
<tr><td> <em>Response:</em> <p>The <strong>My Accounts</strong> page verifies the user's login status and retrieves their account<br>details from the <code inline="">Accounts</code> table, limiting the results to the five most<br>recently modified accounts. For each account, the system dynamically calculates the balance by<br>summing credits (<code inline="">account_dest</code>) and subtracting debits (<code inline="">account_src</code>) from the <code inline="">Transactions</code><br>table, and displays the <code inline="">account_number</code>, <code inline="">account_type</code>, <code inline="">modified</code> date, and <code<br>inline="">balance</code> in a table format. Each row includes a "Learn More" button that<br>links to the <code inline="">transaction_history.php</code> page, passing the account number as a query<br>parameter to fetch detailed transaction history. If no accounts exist, a prompt to<br>create a new account is displayed, ensuring a consistent and user-friendly experience.</p><br></td></tr>
<tr><td> <em>Sub-Task 3: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/kushv01/it202project/pull/6">https://github.com/kushv01/it202project/pull/6</a> </td></tr>
<tr><td> <em>Sub-Task 4: </em> Add a direct link to heroku prod for this file</td></tr>
<tr><td>Not provided</td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 6: </em> Deposit/Withdraw </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707834-bf5a5b13-ec36-4597-9741-aa830c195be2.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Show a Screenshot of the Deposit Page</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-20T00.04.12Screenshot%202024-12-19%20at%207.04.07%20PM.png.webp?alt=media&token=ab5ff1ee-1bfd-4d41-bfc7-18424e13e89b"/></td></tr>
<tr><td> <em>Caption:</em> <p>deposit page<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Show a Screenshot of the Withdraw Page (this potentially can be the same page with different views)</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-20T00.04.54Screenshot%202024-12-19%20at%207.04.48%20PM.png.webp?alt=media&token=332f1345-7460-4203-9441-647da0c32f59"/></td></tr>
<tr><td> <em>Caption:</em> <p>withdraw page<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 3: </em> Show validation error for negative numbers</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-20T00.05.22Screenshot%202024-12-19%20at%207.05.18%20PM.png.webp?alt=media&token=5c8fd2d5-4c8d-41d5-a5ad-ef9fa9f92bd5"/></td></tr>
<tr><td> <em>Caption:</em> <p>negative withdraw<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 4: </em> Show validation error for withdrawing more than the account contains</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-20T00.05.50Screenshot%202024-12-19%20at%207.05.47%20PM.png.webp?alt=media&token=9b3c148d-84f8-46b7-83ce-135d48feb1f2"/></td></tr>
<tr><td> <em>Caption:</em> <p>insufficient funds<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 5: </em> Show a success message for deposit and withdraw (2 screenshots)</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-20T00.06.22Screenshot%202024-12-19%20at%207.06.15%20PM.png.webp?alt=media&token=d07a4143-2afd-46bc-aa01-436b4bbe0a55"/></td></tr>
<tr><td> <em>Caption:</em> <p>withdraw success<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-20T00.06.58Screenshot%202024-12-19%20at%207.06.56%20PM.png.webp?alt=media&token=972fc193-2f51-40de-a7ca-ab3769871f3e"/></td></tr>
<tr><td> <em>Caption:</em> <p>deposit success<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 6: </em> Show a screenshot of the transaction pairs in the DB for the above tests</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fkv378%2F2024-12-20T00.07.57Screenshot%202024-12-19%20at%207.07.55%20PM.png.webp?alt=media&token=d503cd3b-9031-4ca3-919f-81a25e8e4d2c"/></td></tr>
<tr><td> <em>Caption:</em> <p>database<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 7: </em> Briefly explain how transactions work</td></tr>
<tr><td> <em>Response:</em> <ol><li><p><strong>Account Lookup</strong>:</p><br><ul><br><li>The system fetches the details of the user’s selected account and the<br><strong>world account</strong> from the database to ensure the accounts are valid and accessible<br>for the transaction.</li><br><li>Each account’s <strong>current balance</strong> is calculated dynamically by summing all previous<br>transactions (credits and debits) related to the account from the <strong>Transactions table</strong>.</li><br></ul><br></li><br><li><br><p><strong>Expected Total<br>Calculation</strong>:</p><br><ul><br><li>Before the transaction is processed, the <strong>expected total balance</strong> for both the source<br>and destination accounts is calculated:<br><ul><br><li>For withdrawals: The user’s account balance is decreased, and<br>the world account balance is increased.</li><br><li>For deposits: The user’s account balance is increased,<br>and the world account balance is decreased.</li><br></ul><br></li><br><li>This ensures that no invalid or overdraft<br>transactions occur.</li><br></ul><br></li><br><li><br><p><strong>Recording Two Transaction Records</strong>:</p><br><ul><br><li>Each transaction is logged as a <strong>pair of records</strong><br>in the <strong>Transactions table</strong>:<br><ul><br><li><strong>Debit Record</strong>: Represents funds being deducted from the source account.</li><br><li><strong>Credit<br>Record</strong>: Represents funds being added to the destination account.</li><br></ul><br></li><br><li>Both records include:<br><ul><br><li><code inline="">account_src</code> and<br><code inline="">account_dest</code> IDs.</li><br><li><code inline="">balance_change</code> (positive or negative based on direction).</li><br><li><code inline="">expected_total</code> for each<br>account after the transaction.</li><br><li>Additional metadata like transaction type and memo.</li><br></ul><br></li><br></ul><br></li><br><li><br><p><strong>Updating Account Balances</strong>:</p><br><ul><br><li>After recording<br>the transactions, the <strong>Accounts table</strong> is updated by recalculating the total balance:<br><ul><br><li>The system<br>dynamically computes the balance by <strong>summing all balance changes</strong> from the <strong>Transactions table</strong><br>for each account.</li><br></ul><br></li><br><li>This ensures that the displayed balance always reflects the transaction history<br>accurately.</li><br></ul><br></li><br><li><br><p><strong>Error Handling</strong>:</p><br><ul><br><li>If any part of the process fails (e.g., insufficient funds, invalid account),<br>the entire transaction is rolled back to maintain data consistency.</li><br><li>User-friendly error messages are<br>shown to guide the user in correcting the issue.</li><br></ul><br></li><br><li><br><p><strong>User Confirmation</strong>:</p><br><ul><br><li>After successful completion, the<br>system displays a confirmation message with the updated balances of both accounts and<br>redirects the user back to the dashboard or relevant page.</li><br></ul><br></li></ol><br></td></tr>
<tr><td> <em>Sub-Task 8: </em> Add related pull request link(s)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/kushv01/it202project/pull/7">https://github.com/kushv01/it202project/pull/7</a> </td></tr>
<tr><td> <em>Sub-Task 9: </em> Add a direct link to heroku prod for this file</td></tr>
<tr><td>Not provided</td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 7: </em> Misc </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707795-a9c94a71-7871-4572-bfae-ad636f8f8474.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add screenshots showing which issues are done/closed (project board) </td></tr>
<tr><td><table><tr><td>Missing Image</td></tr>
<tr><td> <em>Caption:</em> (missing)</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Add a link to your herok prod project's login page</td></tr>
<tr><td>Not provided</td></tr>
</table></td></tr>
<table><tr><td><em>Grading Link: </em><a rel="noreferrer noopener" href="https://learn.ethereallab.app/homework/IT202-AR451-M2024/it202-milestone-2-bank-project/grade/kv378" target="_blank">Grading</a></td></tr></table>