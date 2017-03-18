

import java.util.regex.Pattern;
import java.util.concurrent.TimeUnit;

import org.junit.*;

import static org.junit.Assert.*;
import static org.hamcrest.CoreMatchers.*;

import org.openqa.selenium.*;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.remote.DesiredCapabilities;
import org.openqa.selenium.support.ui.Select;

public class SeleniumTest {
  private WebDriver driver;
  private String baseUrl;
  private boolean acceptNextAlert = true;
  private StringBuffer verificationErrors = new StringBuffer();


  
  
  @Before
  public void setUp() throws Exception {
    System.setProperty("webdriver.gecko.driver", "C:\\Users\\Erkan\\Desktop\\geckodriver-v0.15.0-win64\\geckodriver.exe");
    driver = new FirefoxDriver();
    baseUrl = "http://localhost/";
    driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
  }

  
  @Test
  public void testRegister() throws Exception {
    driver.get(baseUrl + "/3year/");
    driver.findElement(By.linkText("Register")).click();
    driver.findElement(By.name("username")).clear();
    driver.findElement(By.name("username")).sendKeys("test");
    driver.findElement(By.name("email")).clear();
    driver.findElement(By.name("email")).sendKeys("test@abv.bg");
    driver.findElement(By.name("password")).clear();
    driver.findElement(By.name("password")).sendKeys("test2");
    driver.findElement(By.name("password2")).clear();
    driver.findElement(By.name("password2")).sendKeys("test2");
    driver.findElement(By.name("submit")).click();
  } 
  
 
  @Test
  public void testLogin() throws Exception {
	    driver.get(baseUrl + "/3Year/login.php");
	    driver.findElement(By.name("usernameLogin")).clear();
	    driver.findElement(By.name("usernameLogin")).sendKeys("test");
	    driver.findElement(By.name("passwordLogin")).clear();
	    driver.findElement(By.name("passwordLogin")).sendKeys("test2");
	    driver.findElement(By.name("submitLogin")).click();
  }
  
  
  @Test
  public void testUpload() throws Exception {
	    driver.get(baseUrl + "/3year/");
	    driver.findElement(By.linkText("Sign in")).click();
	    driver.findElement(By.name("usernameLogin")).clear();
	    driver.findElement(By.name("usernameLogin")).sendKeys("erkan");
	    driver.findElement(By.name("passwordLogin")).clear();
	    driver.findElement(By.name("passwordLogin")).sendKeys("erkan");
	    driver.findElement(By.name("submitLogin")).click();
	    driver.findElement(By.linkText("Sell")).click();
	    driver.findElement(By.name("title")).clear();
	    driver.findElement(By.name("title")).sendKeys("lenovo");
	    new Select(driver.findElement(By.name("state"))).selectByVisibleText("Electronics");
	    driver.findElement(By.name("descr")).clear();
	    driver.findElement(By.name("descr")).sendKeys("i7");
	    driver.findElement(By.name("price")).clear();
	    driver.findElement(By.name("price")).sendKeys("500");
	    driver.findElement(By.name("image")).clear();
	    driver.findElement(By.name("image")).sendKeys("C:\\Users\\Erkan\\Desktop\\Pics\\dell.jpg");
	    driver.findElement(By.name("submitimg")).click();  }
  
  @Test
  public void testBid() throws Exception {
    driver.get(baseUrl + "/3Year/index.php");
    driver.findElement(By.linkText("Sign in")).click();
    driver.findElement(By.name("usernameLogin")).clear();
    driver.findElement(By.name("usernameLogin")).sendKeys("denis");
    driver.findElement(By.name("passwordLogin")).clear();
    driver.findElement(By.name("passwordLogin")).sendKeys("denis");
    driver.findElement(By.name("submitLogin")).click();
    driver.findElement(By.cssSelector("div.radded > ul > li > div.product_view_button")).click();
    driver.findElement(By.cssSelector("div.bid_button")).click();
    driver.findElement(By.name("thebid")).clear();
    driver.findElement(By.name("thebid")).sendKeys("600");
    driver.findElement(By.name("placebid")).click();
  }

  @Test
  public void testBuy() throws Exception {
    driver.get(baseUrl + "/3Year/index.php");
    driver.findElement(By.linkText("Sign in")).click();
    driver.findElement(By.name("usernameLogin")).clear();
    driver.findElement(By.name("usernameLogin")).sendKeys("denis");
    driver.findElement(By.name("passwordLogin")).clear();
    driver.findElement(By.name("passwordLogin")).sendKeys("denis");
    driver.findElement(By.name("submitLogin")).click();
    driver.findElement(By.cssSelector("div.radded > ul > li > div.product_view_button")).click();
    driver.findElement(By.cssSelector("div.buy_button")).click();
  }
  
  @Test
  public void testSearch() throws Exception {
    driver.get(baseUrl + "/3year/");
    driver.findElement(By.name("search")).clear();
    driver.findElement(By.name("search")).sendKeys("mercedes c220");
    driver.findElement(By.name("searchButton")).click();
  }
  
  @After
  public void tearDown() throws Exception {
    driver.quit();
    String verificationErrorString = verificationErrors.toString();
    if (!"".equals(verificationErrorString)) {
      fail(verificationErrorString);
    }
  }

  private boolean isElementPresent(By by) {
    try {
      driver.findElement(by);
      return true;
    } catch (NoSuchElementException e) {
      return false;
    }
  }

  private boolean isAlertPresent() {
    try {
      driver.switchTo().alert();
      return true;
    } catch (NoAlertPresentException e) {
      return false;
    }
  }

  private String closeAlertAndGetItsText() {
    try {
      Alert alert = driver.switchTo().alert();
      String alertText = alert.getText();
      if (acceptNextAlert) {
        alert.accept();
      } else {
        alert.dismiss();
      }
      return alertText;
    } finally {
      acceptNextAlert = true;
    }
  }
}
