1. drop key constraint on ViewerId      
    ALTER TABLE feedback DROP FOREIGN KEY feedback_ibfk_1;
2. add auto increment
    ALTER TABLE VIEWER MODIFY ViewerId INT NOT NULL AUTO_INCREMENT;
3. turn FK back on
    ALTER TABLE feedback ADD CONSTRAINT feedback_ibfk_1 FOREIGN KEY (ViewerId) REFERENCES VIEWER(ViewerId);

