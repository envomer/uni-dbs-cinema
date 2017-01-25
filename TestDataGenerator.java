import java.sql.*;
import oracle.jdbc.driver.*;

public class TestDataGenerator
{
	public static void main(String args[])
	{
		try {
			Class.forName("oracle.jdbc.driver.OracleDriver");
			String database = "jdbc:oracle:thin:@oracle-lab.cs.univie.ac.at:1521:lab";
			String user = "a1267512";
			String pass = "dbs16";

			Connection con = DriverManager.getConnection(database, user, pass);
			Statement stmt = con.createStatement();

			try {
				for (int i=0; i < 100; i++){
					String insertSql =  "";
					
	  				insertSql = "INSERT INTO persons (street, zip, city, name) VALUES ('Street "+i+"', '3098"+i+"','City "+i+"', 'Person "+i+"')";
	  				stmt.executeUpdate(insertSql);

	  				insertSql = "INSERT INTO movies (title, duration, image) VALUES ('Movie "+i+"', '"+i+"','Image "+i+"')";
	  				stmt.executeUpdate(insertSql);

		  			insertSql = "INSERT INTO cinemas (cinema_name, street, zip, city) VALUES ('Kino "+i+"', 'Street "+i+"', '1"+i+"', 'City "+i+"')";
	  				stmt.executeUpdate(insertSql);

	  				insertSql = "INSERT INTO rooms (name, cinema_id) VALUES ('Raum "+i+"', "+i+")";
	  				stmt.executeUpdate(insertSql);

	  				insertSql = "INSERT INTO customers (email, password, person_id) VALUES ('email"+i+"@test.com', 'password"+i+"', '"+i+"')";
	  				stmt.executeUpdate(insertSql);

	  				insertSql = "INSERT INTO employees (social_security_nr, phone, person_id, cinema_id) VALUES ('736"+i+"', '056"+i+"', '"+i+"', '"+i+"')";
	  				stmt.executeUpdate(insertSql);

	  				insertSql = "INSERT INTO movie_slots (room_id, start_at, movie_id) VALUES ('"+i+"', to_date('2017-01-26 10:10', 'YYYY-MM-DD HH24:MI','NLS_DATE_LANGUAGE=AMERICAN'), '"+i+"')";
	  				stmt.executeUpdate(insertSql);

	  				insertSql = "INSERT INTO tickets (seat, purchased_at, row_nr, movie_slot_id, employee_id, customer_id, price) VALUES ('"+i+"', to_date('2017-01-26 10:10', 'YYYY-MM-DD HH24:MI','NLS_DATE_LANGUAGE=AMERICAN'), '"+i+"', '"+i+"', '"+i+"', '"+i+"', '"+(i*4)+"')";
	  				stmt.executeUpdate(insertSql);
	    		}

			} catch (Exception e) {
				System.err.println("Error while inserting data: " + e.getMessage());
	        }

			ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM persons");
			if (rs.next()) {
				int count = rs.getInt(1);
				System.out.println("Number of datasets: " + count);
			}

			rs.close();
			stmt.close();
			con.close();
		} catch (Exception e) {
			System.err.println(e.getMessage());
		}
	}
}
