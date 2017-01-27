import { CoffitechPage } from './app.po';

describe('coffitech App', function() {
  let page: CoffitechPage;

  beforeEach(() => {
    page = new CoffitechPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('pr works!');
  });
});
