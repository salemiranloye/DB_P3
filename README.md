# Database Migration Steps

<!-- Jordan Smith-Acquah 1002098372 -->
<!-- Salem Iranloye 1002156031 -->

1. Drop key constraint on ViewerId      
   ```sql
   ALTER TABLE feedback DROP FOREIGN KEY feedback_ibfk_1;
   ```

2. Add auto increment
   ```sql
   ALTER TABLE VIEWER MODIFY ViewerId INT NOT NULL AUTO_INCREMENT;
   ```

3. Turn FK back on
   ```sql
   ALTER TABLE feedback ADD CONSTRAINT feedback_ibfk_1 FOREIGN KEY (ViewerId) REFERENCES VIEWER(ViewerId);
   ```