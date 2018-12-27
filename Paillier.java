import java.math.*;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.*;

public class Paillier 
{

	private BigInteger p, q; 									//p and q are two large primes.
	private BigInteger	lambda;									//lambda = lcm(p-1, q-1) = (p-1)*(q-1)/gcd(p-1, q-1)
	
	public BigInteger n;										//n = p*q, where n is the RSA modulus and p,q are two large primes.
	public BigInteger nsquare;									// nsquare = n*n
	private BigInteger g;										// a random integer in Z* where gcd (L(g^lambda mod n^2), n) = 1.
	private int bitLength,certainty;										// number of bits of modulus
	private static Scanner sc;
	
	Paillier()
	{
		System.out.println("Computation Inside Constructor");
		bitLength = 32;
		certainty = 32;
		/*Constructs two randomly generated positive BigIntegers that are probably prime, with the specified bitLength and certainty.*/
		p = new BigInteger("100043");
		q = new BigInteger("10007");
		
		n = p.multiply(q);
		System.out.println("n: "+n);
		nsquare = n.multiply(n);
		
		g = new BigInteger("7");
		lambda = (p.subtract(BigInteger.ONE).multiply(q.subtract(BigInteger.ONE))).divide(p.subtract(BigInteger.ONE).gcd(q.subtract(BigInteger.ONE)));
		System.out.println("Lambda: "+lambda);
		
		BigInteger L = g.modPow(lambda, nsquare).subtract(BigInteger.ONE).divide(n);
		/* check whether g is good.*/
		if (L.gcd(n).intValue() != 1) 
		{
			System.out.println("g is not good. Choose g again.");
			System.exit(1);
		}
		else 
			System.out.println("G: "+g);
	}
		
	/* Encrypts plaintext as ciphertext, c = g^m * r^n mod n^2 with random r generated.*/
	public BigInteger Encryption(BigInteger message) 
	{
		BigInteger randomNumber = new BigInteger(bitLength, new Random());
		//System.out.println("3 with message: "+message);
		return g.modPow(message, nsquare).multiply(randomNumber.modPow(n, nsquare));//.mod(nsquare);
	}
	
	/*   Decrypts ciphertext as plaintext, m = L(c^lambda mod n^2) * u mod n, where u = (L(g^lambda mod n^2))^(-1) mod n.  */
	public BigInteger Decryption(BigInteger cipherText) 
	{
		BigInteger L = g.modPow(lambda, nsquare).subtract(BigInteger.ONE).divide(n).modInverse(n);    //L= ((((g^lambda %nsquare)-1)/n)^-1)%n
		BigInteger plainText = cipherText.modPow(lambda, nsquare).subtract(BigInteger.ONE).divide(n).multiply(L).mod(n);
		return plainText;
	}
	private static final String hostname = "jdbc:mysql://localhost:3306/poll";
    private static final String userName = "root";
    private static final String password = "";
    
	public static void main(String[] args) throws SQLException 
	{
		/* instantiating an object of Paillier cryptosystem*/
		Paillier p = new Paillier();
		sc = new Scanner(System.in);
		Connection conn = null;
        try
        {
            conn = DriverManager.getConnection(hostname,userName,password);
            if(!conn.isClosed())
                System.out.println("Connected to the database");
                
                String query1 = "Select candidate_id,candidate_cvotes FROM tbcandidates";
                Statement stmt = conn.createStatement();
                ResultSet rs = stmt.executeQuery(query1);
                while(rs.next())
                	System.out.println(rs.getString(1)+" "+rs.getString(2));
                int size = 3;
    			System.out.println("Computation Inside Main()");
    			for(int i=0;i<size;i++)
    			{
    					/* instantiating two plaintext msgs*/
    					
    					System.out.println("Enter Plaintext1 and Plaintext2");
    					String voter_Id = sc.next();
    					String candidate_Id = sc.next();
    					BigInteger m1 = new BigInteger(voter_Id);
    					BigInteger m2 = new BigInteger(candidate_Id);
    					/* encryption and printing ciphertext*/
    					BigInteger em1 = p.Encryption(m1);
    					BigInteger em2 = p.Encryption(m2);
    					System.out.println("Encrypted form of ("+p.Decryption(em1)+") is "+em1);
    					System.out.println("Encrypted form of ("+p.Decryption(em2)+") is "+em2);
    					BigInteger em1_add_em2 = em1.add(em2);
    					BigInteger product_em1em2 = em1.multiply(em2).mod(p.nsquare);
    					System.out.println("Encrypted Sum of ("+p.Decryption(em1)+") and ("+p.Decryption(em2)+") is "+em1_add_em2.toString());
    					System.out.println("Encrypted Product of ("+p.Decryption(em1)+") and ("+p.Decryption(em2)+") is "+product_em1em2.toString());
    					System.out.println("Inserting into Databases");
    					String query2 = "Insert into cloud_db(Encrypted_Sum,Encrypted_Product)"+"values(?,?)";
    					PreparedStatement preparedStatement = conn.prepareStatement(query2);
    					preparedStatement.setString(1,new String(em1_add_em2.toString()));
    					preparedStatement.setString(2,new String(product_em1em2.toString()));
    					preparedStatement.executeUpdate();
    			}
    			String query3 = "SELECT Encrypted_Sum,Encrypted_Product FROM cloud_db";
    			stmt = conn.createStatement();
    			rs = stmt.executeQuery(query3);
    			while(rs.next())
    			{
    				String dbValue1 = rs.getString(1);
    				String dbValue2 = rs.getString(2);
    				BigInteger BdbValue1 = new BigInteger(dbValue2);
    				BigInteger BdbValue2 = new BigInteger(dbValue1);
    				System.out.println("decrypted sum of value from DB is " + p.Decryption(BdbValue1));
    				System.out.println("decrypted product of value from DB is " + p.Decryption(BdbValue2));
                }
//    					System.out.println("Decrypted value of ("+em1+") is "+p.Decryption(em1).toString());
//    					System.out.println("Decrypted value of ("+em2+") is "+p.Decryption(em2).toString());
//    					
//    					/* test homomorphic properties -> D(E(m1)*E(m2) mod n^2) = (m1 + m2) mod n */
//    					BigInteger sum_m1m2 = m1.add(m2).mod(p.n);
//    					//System.out.println("Encrypted Sum: "+paillier.Encryption(sum_m1m2));
//    					System.out.println("original sum: " + sum_m1m2.toString());
//    					System.out.println("decrypted sum of "+em1_add_em2+" is " + p.Decryption(product_em1em2).toString());
//    					
//    					/* test homomorphic properties -> D(E(m1)^m2 mod n^2) = (m1*m2) mod n */
//    					BigInteger expo_em1m2 = em1.modPow(m2, p.nsquare);
//    					BigInteger prod_m1m2 = m1.multiply(m2).mod(p.n);
//    					System.out.println("original product: " + prod_m1m2.toString());
//    					System.out.println("decrypted product: " + p.Decryption(expo_em1m2).toString());
//    					String x = p.Decryption(em1_add_em2.subtract(em1)).toString();
//    					System.out.println("The vote was for "+Integer.parseInt(x));
//    					String query3 = "UPDATE tbcandidates set candidate_cvotes = candidate_cvotes+1";//+"where candidate_id = ?";
//    					PreparedStatement pStmt = conn.prepareStatement(query3);
//    					//pStmt.setString(1, x);
//    					pStmt.executeUpdate();
//    					
//    			}
        }
        catch(Exception ae)
      {
          System.err.println(ae.getMessage());
      }
      finally
      {
          try
          {
              if(conn!=null)
                  conn.close();
          }
          catch(SQLException se){}
      }
	}
}
 

